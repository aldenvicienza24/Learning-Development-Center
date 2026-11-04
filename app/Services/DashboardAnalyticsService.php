<?php

namespace App\Services;

use App\Models\Program;
use App\Models\Registration;
use Carbon\CarbonImmutable;
use Symfony\Component\Process\Process;

class DashboardAnalyticsService
{
    public function calculate(array $filters): array
    {
        $programs = Program::query()
            ->when($filters['program_id'] ?? null, fn ($query, $id) => $query->whereKey($id))
            ->when($filters['category'] ?? null, fn ($query, $category) => $query->where('category', $category))
            ->orderBy('title')
            ->get(['id', 'title', 'category', 'price', 'total_quota', 'quota', 'execution_date']);

        // Only anonymous counts and confirmed receipt totals leave Laravel.
        $scope = Registration::query()
            ->whereIn('program_id', $programs->modelKeys())
            ->when($filters['payment_status'] ?? null, fn ($query, $status) => $query->where('payment_status', $status))
            ->when($filters['participant_status'] ?? null, fn ($query, $status) => $query
                ->whereRaw("COALESCE(NULLIF(participant_status, ''), status, 'menunggu_verifikasi') = ?", [$status]));
        // Normalize dates/statuses first, then group plain columns in the outer
        // query. This avoids relying on GROUP BY expression/alias resolution
        // differences between MySQL and older MariaDB under ONLY_FULL_GROUP_BY.
        $registrationRows = (clone $scope)
            ->where('created_at', '>=', CarbonImmutable::parse($filters['start_date'])->startOfDay())
            ->where('created_at', '<', CarbonImmutable::parse($filters['end_date'])->addDay()->startOfDay())
            ->selectRaw("program_id, DATE(created_at) as registration_date, COALESCE(payment_status, '') as payment_status, COALESCE(NULLIF(participant_status, ''), status, 'menunggu_verifikasi') as participant_status");
        $connection = $scope->getModel()->getConnection();
        $rows = $connection->query()->fromSub($registrationRows, 'analytics_registrations')
            ->select('program_id', 'registration_date', 'payment_status', 'participant_status')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('program_id', 'registration_date', 'payment_status', 'participant_status')
            ->get()->map(fn ($row) => (array) $row)->all();

        // Approved payments are recognized income. Legacy records lacking a receipt
        // date stay in the report using their registration date, disclosed in the UI.
        $date = 'DATE(COALESCE(payment_received_at, created_at))';
        $receiptRows = (clone $scope)->where('payment_status', 'disetujui')->whereNotNull('payment_amount')
            ->whereRaw("$date >= ? AND $date <= ?", [$filters['start_date'], $filters['end_date']])
            ->selectRaw("program_id, $date as received_date, payment_amount, CASE WHEN payment_received_at IS NULL THEN 1 ELSE 0 END as legacy_date");
        $receipts = $connection->query()->fromSub($receiptRows, 'analytics_receipts')
            ->select('program_id', 'received_date')
            ->selectRaw('COUNT(*) as total, SUM(payment_amount) as amount, SUM(legacy_date) as legacy_dates')
            ->groupBy('program_id', 'received_date')
            ->get()->map(fn ($row) => (array) $row)->all();
        $missing = (clone $scope)->where('payment_status', 'disetujui')
            ->whereNull('payment_amount')
            ->selectRaw('program_id, COUNT(*) as total')->groupBy('program_id')->get()->toArray();

        $input = [
            'filters' => $filters,
            'programs' => $programs->map(fn (Program $program) => $program->only([
                'id', 'title', 'category', 'price', 'total_quota', 'quota', 'execution_date',
            ]))->all(),
            'registrations' => $rows,
            'receipts' => $receipts,
            'missing_receipts' => $missing,
        ];

        if (config('analytics.engine', 'php') === 'python') {
            // Optional Python engine; hosting defaults to PHP without subprocesses.
            $process = new Process(
                [config('analytics.python_binary'), base_path('analytics/dashboard.py')],
                base_path(),
                ['PYTHONIOENCODING' => 'utf-8', 'PYTHONDONTWRITEBYTECODE' => '1'],
                json_encode($input, JSON_THROW_ON_ERROR),
                config('analytics.timeout'),
            );
            $process->mustRun();
            $result = json_decode($process->getOutput(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            $result = app(PhpDashboardAnalytics::class)->calculate($input);
        }
        $result['summary']['conducted_programs'] = $programs
            ->filter(fn (Program $program): bool => $program->execution_date !== null
                && $program->execution_date->toDateString() >= $filters['start_date']
                && $program->execution_date->toDateString() <= $filters['end_date'])
            ->count();
        $result['program_periods'] = $this->programPeriods(
            $result['programs'],
            $result['periods'],
            $rows,
            $receipts,
            $filters['interval'],
        );
        $result['empty'] = $result['empty'] && $result['summary']['conducted_programs'] === 0;
        $result['generated_at'] = now()->toIso8601String();
        $result['timezone'] = config('app.timezone');
        $result['receipts_completion_url'] = route('admin.registrations.index', array_filter([
            'payment_status' => 'disetujui', 'missing_receipt' => 1, 'program_id' => $filters['program_id'] ?? null,
            'category' => $filters['category'] ?? null, 'participant_status' => $filters['participant_status'] ?? null,
        ]));
        foreach ($result['programs'] as &$program) {
            $program['participants_url'] = route('admin.registrations.index', array_filter([
                'program_id' => $program['id'], 'date_from' => $filters['start_date'], 'date_to' => $filters['end_date'],
                'payment_status' => $filters['payment_status'] ?? null,
                'participant_status' => $filters['participant_status'] ?? null,
            ], fn ($value) => $value !== null && $value !== ''));
        }
        unset($program);

        // Program and category filters also scope traffic to matching program pages.
        $programScopeActive = ! empty($filters['program_id']) || ! empty($filters['category']);
        $pageViewsQuery = \App\Models\PageView::query()
            ->where('created_at', '>=', CarbonImmutable::parse($filters['start_date'])->startOfDay())
            ->where('created_at', '<', CarbonImmutable::parse($filters['end_date'])->addDay()->startOfDay())
            ->where('url', 'not like', '%/admin%')
            ->where('url', 'not like', '%/cms%')
            ->when($programScopeActive, fn ($query) => $query->whereIn('program_id', $programs->modelKeys()));

        $totalVisitors = (clone $pageViewsQuery)->distinct('session_id')->count('session_id');
        $trainingPageViews = (clone $pageViewsQuery)->whereNotNull('program_id')->count();
        
        $popularProgramsViews = (clone $pageViewsQuery)
            ->whereNotNull('program_id')
            ->selectRaw('program_id, COUNT(*) as views')
            ->groupBy('program_id')
            ->orderByDesc('views')
            ->get();
            
        $popularProgramsViewsData = [];
        foreach ($popularProgramsViews as $pv) {
            $programObj = $programs->firstWhere('id', $pv->program_id);
            if ($programObj) {
                $popularProgramsViewsData[] = [
                    'program_id' => $pv->program_id,
                    'title' => $programObj->title,
                    'views' => $pv->views,
                ];
            }
        }
        
        $totalRegistrants = $result['summary']['registrations'] ?? 0;
        $pageViewsRaw = (clone $pageViewsQuery)->get(['session_id', 'created_at']);
        $visitorSessionIds = $pageViewsRaw->pluck('session_id')->filter()->unique()->values();
        $interval = $filters['interval'] ?? 'month';
        $visitorsByPeriod = [];
        foreach ($pageViewsRaw as $view) {
            $key = $this->periodKey($view->created_at->toDateString(), $interval);
            $visitorsByPeriod[$key][$view->session_id] = true;
        }
        $websiteRegistrationRows = collect();
        if ($visitorSessionIds->isNotEmpty()) {
            $websiteRegistrationRows = (clone $scope)
                ->whereNotNull('visitor_id')
                ->whereIn('visitor_id', $visitorSessionIds->all())
                ->where('created_at', '>=', CarbonImmutable::parse($filters['start_date'])->startOfDay())
                ->where('created_at', '<', CarbonImmutable::parse($filters['end_date'])->addDay()->startOfDay())
                ->get(['visitor_id', 'created_at']);
            $websiteRegistrationRows = $websiteRegistrationRows
                ->filter(function ($registration) use ($interval, $visitorsByPeriod): bool {
                    $key = $this->periodKey($registration->created_at->toDateString(), $interval);

                    return isset($visitorsByPeriod[$key][$registration->visitor_id]);
                })
                ->values();
        }
        $websiteRegistrants = $websiteRegistrationRows->count();
        $convertedVisitors = $websiteRegistrationRows->pluck('visitor_id')->unique()->count();
        $conversionRate = $totalVisitors > 0
            ? round($convertedVisitors / $totalVisitors * 100, 2)
            : null;

        $result['visitors'] = [
            'total_visitors' => $totalVisitors,
            'training_page_views' => $trainingPageViews,
            'popular_training_views' => $popularProgramsViewsData,
            'total_registrants' => $totalRegistrants,
            'website_registrants' => $websiteRegistrants,
            'converted_visitors' => $convertedVisitors,
            'conversion_rate' => $conversionRate,
            'attribution_available' => true,
            'scope' => $programScopeActive ? 'filtered_program_pages' : 'all_website_pages',
        ];

        $websiteRegistrationsByPeriod = [];
        $convertedVisitorsByPeriod = [];
        foreach ($websiteRegistrationRows as $registration) {
            $key = $this->periodKey($registration->created_at->toDateString(), $interval);
            if (! isset($visitorsByPeriod[$key][$registration->visitor_id])) {
                continue;
            }
            $websiteRegistrationsByPeriod[$key] = ($websiteRegistrationsByPeriod[$key] ?? 0) + 1;
            $convertedVisitorsByPeriod[$key][$registration->visitor_id] = true;
        }

        $chartKeys = [];
        $visitorValues = [];
        $registrantValues = [];
        $labels = [];
        $visitorPeriods = [];
        
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        foreach ($result['periods'] as $p) {
            $visitorCount = isset($visitorsByPeriod[$p['period']]) ? count($visitorsByPeriod[$p['period']]) : 0;
            $websiteRegistrantCount = $websiteRegistrationsByPeriod[$p['period']] ?? 0;
            $convertedVisitorCount = isset($convertedVisitorsByPeriod[$p['period']])
                ? count($convertedVisitorsByPeriod[$p['period']])
                : 0;
            $chartKeys[] = $p['period'];
            $visitorValues[] = $visitorCount;
            $registrantValues[] = $websiteRegistrantCount;
            
            if ($interval === 'month') {
                $monthIdx = (int) substr($p['period'], 5, 2) - 1;
                $labels[] = $months[$monthIdx] . ' ' . substr($p['period'], 0, 4);
            } else {
                $day = \Carbon\CarbonImmutable::parse($p['start_date']);
                $labels[] = $day->day . ' ' . $months[$day->month - 1];
            }
            $visitorPeriods[] = [
                'period' => $p['period'],
                'label' => end($labels),
                'start_date' => $p['start_date'],
                'end_date' => $p['end_date'],
                'unique_visitors' => $visitorCount,
                'registrations' => $p['registrations'],
                'website_registrants' => $websiteRegistrantCount,
                'converted_visitors' => $convertedVisitorCount,
                'conversion_rate' => $visitorCount > 0
                    ? round($convertedVisitorCount / $visitorCount * 100, 2)
                    : null,
            ];
        }
        $result['visitors']['periods'] = $visitorPeriods;

        $maximum = max(array_merge($visitorValues ?: [0], $registrantValues ?: [0]));
        $step = max(1, intdiv(count($chartKeys) + 5, 6));
        $indices = array_unique([...range(0, count($chartKeys) - 1, $step), count($chartKeys) - 1]);
        sort($indices);
        
        $tickvals = array_map(fn ($i) => $chartKeys[$i] ?? '', $indices);
        $ticktext = array_map(fn ($i) => $labels[$i] ?? '', $indices);

        $result['charts']['visitors_trend'] = [
            'data' => [
                [
                    'type' => 'scatter', 'mode' => 'lines+markers', 'name' => 'Pengunjung unik',
                    'x' => $chartKeys, 'y' => $visitorValues,
                    'line' => ['color' => '#53657d', 'width' => 3],
                    'marker' => ['color' => '#53657d', 'size' => 7, 'line' => ['color' => '#fff', 'width' => 2]],
                    'customdata' => $labels,
                    'hovertemplate' => '%{customdata}<br>Pengunjung unik: %{y:,.0f}<extra></extra>',
                ],
                [
                    'type' => 'scatter', 'mode' => 'lines+markers', 'name' => 'Pendaftar dari situs web',
                    'x' => $chartKeys, 'y' => $registrantValues,
                    'line' => ['color' => '#a92b45', 'width' => 3],
                    'marker' => ['color' => '#a92b45', 'size' => 7, 'line' => ['color' => '#fff', 'width' => 2]],
                    'customdata' => $labels,
                    'hovertemplate' => '%{customdata}<br>Pendaftar dari situs web: %{y:,.0f}<extra></extra>',
                ]
            ],
            'layout' => [
                'showlegend' => false, 'hovermode' => 'x unified', 'margin' => ['l' => 46, 'r' => 18, 't' => 14, 'b' => 38],
                'xaxis' => ['type' => 'category', 'automargin' => true, 'fixedrange' => true, 'showgrid' => false, 'zeroline' => false, 'tickvals' => $tickvals, 'ticktext' => $ticktext],
                'yaxis' => ['range' => [0, max(5, $maximum * 1.16)], 'gridcolor' => '#e8ecf1', 'griddash' => 'dot', 'zeroline' => false, 'fixedrange' => true, 'rangemode' => 'tozero', 'tickformat' => ',d'],
                'paper_bgcolor' => 'rgba(0,0,0,0)', 'plot_bgcolor' => 'rgba(0,0,0,0)',
                'font' => ['family' => 'Inter, Arial, sans-serif', 'color' => '#596577', 'size' => 11],
                'hoverlabel' => ['bgcolor' => '#fff', 'bordercolor' => '#e8dce0', 'align' => 'left', 'font' => ['color' => '#49323b', 'size' => 13]],
            ]
        ];
        $topPrograms = array_slice($popularProgramsViewsData, 0, 5);
        $topProgramsRev = array_reverse($topPrograms);
        
        $result['charts']['popular_programs_views'] = empty($topProgramsRev) ? [] : [
            'data' => [[
                'type' => 'bar', 'orientation' => 'h', 
                'x' => array_map(fn($p) => $p['views'], $topProgramsRev),
                'y' => array_map(fn ($p) => (string) $p['program_id'], $topProgramsRev),
                'marker' => ['color' => array_map(fn ($index) => $index === count($topProgramsRev) - 1 ? '#a92b45' : '#9d596b', array_keys($topProgramsRev)), 'cornerradius' => 6],
                'text' => array_map(fn($p) => number_format($p['views'], 0, ',', '.'), $topProgramsRev),
                'textposition' => 'outside',
                'textfont' => ['color' => '#7f3045', 'size' => 12],
                'cliponaxis' => false,
                'customdata' => array_map(fn ($p) => [$p['program_id'], htmlspecialchars($p['title'], ENT_QUOTES), $p['views']], $topProgramsRev),
                'hovertemplate' => '%{customdata[1]}<br>%{customdata[2]:,.0f} tampilan halaman<extra></extra>',
            ]],
            'layout' => [
                'margin' => ['l' => 158, 'r' => 45, 't' => 12, 'b' => 38],
                'xaxis' => ['fixedrange' => true, 'showgrid' => true, 'gridcolor' => '#edf0f4', 'griddash' => 'dot', 'zeroline' => false, 'rangemode' => 'tozero', 'tickformat' => ',d'],
                'yaxis' => ['fixedrange' => true, 'categoryorder' => 'array', 'categoryarray' => array_map(fn ($p) => (string) $p['program_id'], $topProgramsRev), 'tickvals' => array_map(fn ($p) => (string) $p['program_id'], $topProgramsRev), 'ticktext' => array_map(fn ($p) => htmlspecialchars((string) str($p['title'])->limit(32), ENT_QUOTES), $topProgramsRev)],
                'paper_bgcolor' => 'rgba(0,0,0,0)', 'plot_bgcolor' => 'rgba(0,0,0,0)',
                'font' => ['family' => 'Inter, Arial, sans-serif', 'color' => '#596577', 'size' => 11],
                'showlegend' => false,
                'dragmode' => false,
                'hoverlabel' => ['bgcolor' => '#fff', 'bordercolor' => '#d8dee7', 'align' => 'left', 'font' => ['color' => '#364256', 'size' => 12]],
            ]
        ];

        $activityMaximum = max($totalVisitors, $trainingPageViews, $websiteRegistrants);
        $result['charts']['visitor_activity'] = [
            'data' => [[
                'type' => 'bar',
                'orientation' => 'h',
                'y' => ['Pengunjung unik', 'Tampilan halaman', 'Pendaftar situs web'],
                'x' => [$totalVisitors, $trainingPageViews, $websiteRegistrants],
                'text' => array_map(fn ($value) => number_format($value, 0, ',', '.'), [$totalVisitors, $trainingPageViews, $websiteRegistrants]),
                'textposition' => 'outside',
                'textfont' => ['color' => '#3f4e62', 'size' => 12],
                'cliponaxis' => false,
                'marker' => ['color' => ['#53657d', '#748398', '#a92b45'], 'cornerradius' => 6],
                'hovertemplate' => '%{y}<br>%{x:,.0f}<extra></extra>',
            ]],
            'layout' => [
                'margin' => ['l' => 116, 'r' => 48, 't' => 12, 'b' => 38],
                'xaxis' => ['fixedrange' => true, 'showgrid' => true, 'gridcolor' => '#edf0f4', 'griddash' => 'dot', 'zeroline' => false, 'tickformat' => ',d', 'range' => [0, max(1, $activityMaximum * 1.22)]],
                'yaxis' => ['fixedrange' => true, 'autorange' => 'reversed'],
                'paper_bgcolor' => 'rgba(0,0,0,0)', 'plot_bgcolor' => 'rgba(0,0,0,0)',
                'font' => ['family' => 'Inter, Arial, sans-serif', 'color' => '#596577', 'size' => 11],
                'showlegend' => false,
                'dragmode' => false,
                'hoverlabel' => ['bgcolor' => '#fff', 'bordercolor' => '#d8dee7', 'align' => 'left', 'font' => ['color' => '#364256', 'size' => 12]],
            ]
        ];

        return $result;
    }

    private function programPeriods(array $programs, array $periods, array $registrations, array $receipts, string $interval): array
    {
        $registrationTotals = [];
        foreach ($registrations as $row) {
            $key = $this->periodKey($row['registration_date'], $interval);
            $registrationTotals[(int) $row['program_id']][$key] = ($registrationTotals[(int) $row['program_id']][$key] ?? 0) + (int) $row['total'];
        }

        $revenueTotals = [];
        $receiptTotals = [];
        foreach ($receipts as $row) {
            $key = $this->periodKey($row['received_date'], $interval);
            $programId = (int) $row['program_id'];
            $revenueTotals[$programId][$key] = ($revenueTotals[$programId][$key] ?? 0) + (int) $row['amount'];
            $receiptTotals[$programId][$key] = ($receiptTotals[$programId][$key] ?? 0) + (int) $row['total'];
        }

        $result = [];
        foreach ($programs as $program) {
            foreach ($periods as $period) {
                $programId = (int) $program['id'];
                $key = $period['period'];
                $result[] = [
                    'program_id' => $programId,
                    'title' => $program['title'],
                    'period' => $key,
                    'start_date' => $period['start_date'],
                    'end_date' => $period['end_date'],
                    'registrations' => $registrationTotals[$programId][$key] ?? 0,
                    'receipt_count' => $receiptTotals[$programId][$key] ?? 0,
                    'actual_revenue' => $revenueTotals[$programId][$key] ?? 0,
                ];
            }
        }

        return $result;
    }

    private function periodKey(string $date, string $interval): string
    {
        $day = CarbonImmutable::parse($date);

        return match ($interval) {
            'month' => $day->format('Y-m'),
            'week' => $day->startOfWeek(1)->toDateString(),
            default => $day->toDateString(),
        };
    }
}
