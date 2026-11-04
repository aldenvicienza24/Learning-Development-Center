<?php

namespace App\Services;

use Carbon\CarbonImmutable;

class PhpDashboardAnalytics
{
    private const PAYMENTS = ['disetujui' => 'Disetujui', 'menunggu_pembayaran' => 'Menunggu pembayaran', 'menunggu_verifikasi' => 'Menunggu verifikasi', 'ditolak' => 'Ditolak', 'unknown' => 'Belum diklasifikasi'];

    private const PARTICIPANTS = ['menunggu_pembayaran' => 'Menunggu pembayaran', 'menunggu_verifikasi' => 'Menunggu verifikasi', 'diproses' => 'Diproses', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak', 'unknown' => 'Belum diklasifikasi'];

    private const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    public function calculate(array $payload): array
    {
        $filters = $payload['filters'];
        $start = CarbonImmutable::parse($filters['start_date'], 'UTC')->startOfDay();
        $end = CarbonImmutable::parse($filters['end_date'], 'UTC')->startOfDay();
        $interval = $filters['interval'];
        $programs = [];
        foreach ($payload['programs'] as $source) {
            $capacity = max(0, (int) $source['total_quota']);
            $remaining = min($capacity, max(0, (int) $source['quota']));
            $programs[(int) $source['id']] = array_merge($source, [
                'registrations' => 0, 'approved' => 0, 'actual_revenue' => 0, 'receipt_count' => 0, 'missing_receipts' => 0,
                'capacity' => $capacity, 'remaining' => $remaining, 'occupied' => $capacity - $remaining,
                'payments' => [], 'participants' => [],
            ]);
        }
        $counts = $revenue = $payments = $participants = $approvedByDate = $pendingByDate = $receiptsByDate = [];
        foreach ($payload['registrations'] as $row) {
            $id = (int) $row['program_id'];
            if (! isset($programs[$id]) || $row['registration_date'] < $filters['start_date'] || $row['registration_date'] > $filters['end_date']) {
                continue;
            }
            $key = $this->periodKey($row['registration_date'], $interval);
            $count = (int) $row['total'];
            $payment = isset(self::PAYMENTS[$row['payment_status']]) ? $row['payment_status'] : 'unknown';
            $participant = $row['participant_status'] ?? 'unknown';
            $participant = isset(self::PARTICIPANTS[$participant]) ? $participant : 'unknown';
            $this->increment($counts, $key, $count);
            $this->increment($payments, $payment, $count);
            $this->increment($participants, $participant, $count);
            $programs[$id]['registrations'] += $count;
            $this->increment($programs[$id]['payments'], $payment, $count);
            $this->increment($programs[$id]['participants'], $participant, $count);
            if (in_array($payment, ['menunggu_pembayaran', 'menunggu_verifikasi'], true)) {
                $this->increment($pendingByDate, $key, $count);
            }
            if ($payment === 'disetujui') {
                $this->increment($approvedByDate, $key, $count);
                $programs[$id]['approved'] += $count;
            }
        }
        $legacyDates = 0;
        foreach ($payload['receipts'] ?? [] as $row) {
            $id = (int) $row['program_id'];
            if (! isset($programs[$id]) || $row['received_date'] < $filters['start_date'] || $row['received_date'] > $filters['end_date']) {
                continue;
            }
            $key = $this->periodKey($row['received_date'], $interval);
            $amount = (int) $row['amount'];
            $count = (int) $row['total'];
            $programs[$id]['actual_revenue'] += $amount;
            $programs[$id]['receipt_count'] += $count;
            $this->increment($revenue, $key, $amount);
            $this->increment($receiptsByDate, $key, $count);
            $legacyDates += (int) ($row['legacy_dates'] ?? 0);
        }
        foreach ($payload['missing_receipts'] ?? [] as $row) {
            if (isset($programs[(int) $row['program_id']])) {
                $programs[(int) $row['program_id']]['missing_receipts'] = (int) $row['total'];
            }
        }
        $rows = array_values($programs);
        usort($rows, fn ($a, $b) => ($b['registrations'] <=> $a['registrations']) ?: strcmp($a['title'], $b['title']) ?: ($a['id'] <=> $b['id']));
        foreach ($rows as &$row) {
            $row['popularity_rate'] = $this->rate($row['registrations'], $row['capacity']);
            $row['approval_rate'] = $this->rate($row['approved'], $row['registrations']);
        }
        unset($row);
        $total = array_sum($counts);
        $approved = $payments['disetujui'] ?? 0;
        $receiptCount = array_sum($receiptsByDate);
        $missingCount = array_sum(array_column($rows, 'missing_receipts'));
        $capacity = array_sum(array_column($rows, 'capacity'));
        $occupied = array_sum(array_column($rows, 'occupied'));
        $periods = [];
        $cursor = match ($interval) {
            'month' => $start->startOfMonth(), 'week' => $start->startOfWeek(1), default => $start,
        };
        while ($cursor <= $end) {
            $key = $cursor->format($interval === 'month' ? 'Y-m' : 'Y-m-d');
            $last = match ($interval) {
                'month' => $cursor->endOfMonth()->startOfDay(), 'week' => $cursor->addDays(6), default => $cursor,
            };
            $periods[] = [
                'period' => $key, 'start_date' => $cursor->max($start)->toDateString(), 'end_date' => $last->min($end)->toDateString(),
                'registrations' => $counts[$key] ?? 0, 'approved' => $approvedByDate[$key] ?? 0, 'pending' => $pendingByDate[$key] ?? 0,
                'actual_revenue' => $revenue[$key] ?? 0, 'receipt_count' => $receiptsByDate[$key] ?? 0,
            ];
            $cursor = match ($interval) {
                'month' => $cursor->addMonth(), 'week' => $cursor->addWeek(), default => $cursor->addDay(),
            };
        }
        $programKeys = array_flip(['id', 'title', 'category', 'price', 'registrations', 'approved', 'actual_revenue', 'capacity', 'occupied', 'remaining', 'payments', 'participants', 'approval_rate', 'popularity_rate', 'receipt_count', 'missing_receipts']);

        return [
            'filters' => $filters,
            'summary' => [
                'registrations' => $total, 'approved' => $approved,
                'actual_revenue' => ($receiptCount || ! $missingCount) ? array_sum($revenue) : null,
                'receipt_count' => $receiptCount, 'missing_receipts' => $missingCount, 'legacy_receipt_dates' => $legacyDates,
                'accepted_rate' => $this->rate($participants['diterima'] ?? 0, $total),
                'high_demand_programs' => count(array_filter($rows, fn ($p) => $p['capacity'] && $p['registrations'] / $p['capacity'] >= 0.8)),
                'approval_rate' => $this->rate($approved, $total),
                'pending' => ($payments['menunggu_pembayaran'] ?? 0) + ($payments['menunggu_verifikasi'] ?? 0),
                'accepted' => $participants['diterima'] ?? 0, 'occupied' => $occupied, 'capacity' => $capacity,
                'occupancy_rate' => $this->rate($occupied, $capacity),
            ],
            'charts' => ['revenue_trend' => $this->revenueChart($periods, $interval, $receiptCount > 0), 'popular_programs' => $this->ranking($rows)],
            'programs' => array_values(array_map(function ($p) use ($programKeys) {
                $p['payments'] = (object) $p['payments'];
                $p['participants'] = (object) $p['participants'];

                return array_intersect_key($p, $programKeys);
            }, array_filter($rows, fn ($p) => $p['registrations'] || $p['receipt_count'] || $p['missing_receipts']))),
            'snapshot' => ['capacity' => $capacity, 'occupied' => $occupied, 'remaining' => $capacity - $occupied,
                'programs' => array_map(fn ($p) => array_intersect_key($p, array_flip(['id', 'title', 'capacity', 'occupied', 'remaining'])), $rows)],
            'payment_breakdown' => array_map(fn ($status, $label) => ['status' => $status, 'label' => $label, 'count' => $payments[$status] ?? 0, 'percentage' => $this->rate($payments[$status] ?? 0, $total)], array_keys(self::PAYMENTS), array_values(self::PAYMENTS)),
            'participant_breakdown' => array_map(fn ($status, $label) => ['status' => $status, 'label' => $label, 'count' => $participants[$status] ?? 0], array_keys(self::PARTICIPANTS), array_values(self::PARTICIPANTS)),
            'periods' => $periods, 'empty' => $total === 0 && $receiptCount === 0,
        ];
    }

    private function increment(array &$counts, string $key, int $amount): void
    {
        $counts[$key] = ($counts[$key] ?? 0) + $amount;
    }

    private function periodKey(string $date, string $interval): string
    {
        return match ($interval) {
            'month' => substr($date, 0, 7), 'week' => CarbonImmutable::parse($date, 'UTC')->startOfWeek(1)->toDateString(), default => $date,
        };
    }

    private function rate(int $numerator, int $denominator): ?float
    {
        return $denominator ? round($numerator / $denominator * 100, 1, PHP_ROUND_HALF_EVEN) : null;
    }

    private function figure(array $traces, bool $empty, array $layout): array
    {
        $base = [
            'separators' => ',.', 'paper_bgcolor' => 'rgba(0,0,0,0)', 'plot_bgcolor' => 'rgba(0,0,0,0)',
            'font' => ['family' => 'Inter, Arial, sans-serif', 'color' => '#68717f', 'size' => 11],
            'margin' => ['l' => 60, 'r' => 20, 't' => 20, 'b' => 55],
            'xaxis' => ['gridcolor' => '#f5eff1', 'zeroline' => false, 'automargin' => true],
            'yaxis' => ['gridcolor' => '#f5eff1', 'zeroline' => false, 'rangemode' => 'tozero', 'automargin' => true],
            'legend' => ['orientation' => 'h', 'y' => -0.25, 'x' => 0],
            'hoverlabel' => ['bgcolor' => '#fff', 'bordercolor' => '#e8dce0', 'align' => 'left', 'font' => ['color' => '#49323b', 'size' => 13]],
        ];
        $base = array_replace($base, $layout);
        if ($empty) {
            $traces = [];
            $base = array_replace($base, [
                'annotations' => [['text' => 'Belum ada data untuk filter ini', 'showarrow' => false, 'xref' => 'paper', 'yref' => 'paper', 'x' => 0.5, 'y' => 0.5]],
                'xaxis' => ['visible' => false], 'yaxis' => ['visible' => false], 'shapes' => [],
            ]);
        }

        return ['data' => $traces, 'layout' => $base];
    }

    private function dateLabel(string $date): string
    {
        $day = CarbonImmutable::parse($date, 'UTC');

        return $day->day.' '.self::MONTHS[$day->month - 1].' '.$day->year;
    }

    private function decimalLabel(float $number): string
    {
        return str_replace('.', ',', rtrim(rtrim(number_format(round($number, 1, PHP_ROUND_HALF_EVEN), 1, '.', ''), '0'), '.'));
    }

    private function amountLabel(float $amount): string
    {
        [$unit, $divisor] = match (true) {
            $amount >= 1000000000 => [' miliar', 1000000000], $amount >= 1000000 => [' juta', 1000000],
            $amount >= 1000 => [' ribu', 1000], default => ['', 1],
        };

        return 'Rp '.$this->decimalLabel($amount / $divisor).$unit;
    }

    private function revenueChart(array $periods, string $interval, bool $hasData): array
    {
        $keys = array_column($periods, 'period');
        $values = array_column($periods, 'actual_revenue');
        $labels = array_map(fn ($p) => $interval === 'month' ? self::MONTHS[(int) substr($p['period'], 5, 2) - 1].' '.substr($p['period'], 0, 4) : $this->dateLabel($p['start_date']), $periods);
        $step = max(1, intdiv(count($keys) + 5, 6));
        $indices = array_unique([...range(0, count($keys) - 1, $step), count($keys) - 1]);
        sort($indices);
        $maximum = max($values ?: [0]);
        $magnitude = $maximum ? 10 ** floor(log10($maximum / 4)) : 1;
        $tickStep = $magnitude;
        foreach ([1, 2, 2.5, 5, 10] as $candidate) {
            $tickStep = $candidate * $magnitude;
            if ($tickStep >= $maximum / 4) {
                break;
            }
        }
        $ceiling = $maximum ? ceil($maximum / $tickStep) * $tickStep : 1;
        $ticks = $maximum ? array_map(fn ($i) => $i * $tickStep, range(0, (int) ceil($maximum / $tickStep))) : [0];
        $trace = [
            'type' => 'scatter', 'mode' => 'lines+markers', 'name' => 'Pemasukan tercatat', 'x' => $keys, 'y' => $values,
            'line' => ['color' => '#ad263b', 'width' => 3], 'fill' => 'tozeroy', 'fillcolor' => 'rgba(173,38,59,0.045)',
            'marker' => ['color' => '#ad263b', 'size' => 7, 'line' => ['color' => '#fff', 'width' => 2]],
            'text' => [], 'textposition' => 'top center', 'textfont' => ['size' => 12, 'color' => '#5b3944'], 'cliponaxis' => false,
            'customdata' => array_map(fn ($p) => [$this->dateLabel($p['start_date']).' sampai '.$this->dateLabel($p['end_date']), $p['receipt_count']], $periods),
            'hovertemplate' => '%{customdata[0]}<br>Pemasukan: Rp %{y:,.0f}<br>%{customdata[1]:,.0f} pembayaran tercatat<extra></extra>',
        ];

        return $this->figure([$trace], ! $hasData, [
            'showlegend' => false, 'hovermode' => 'closest', 'margin' => ['l' => 85, 'r' => 25, 't' => 25, 'b' => 45],
            'xaxis' => ['type' => 'category', 'range' => [-0.35, max(0.65, count($keys) - 0.65)],
                'tickvals' => array_map(fn ($i) => $keys[$i], $indices), 'ticktext' => array_map(fn ($i) => $labels[$i], $indices),
                'automargin' => true, 'fixedrange' => false, 'showgrid' => false, 'zeroline' => false, 'tickfont' => ['color' => '#788291', 'size' => 11]],
            'yaxis' => ['tickvals' => $ticks, 'ticktext' => array_map(fn ($v) => $this->amountLabel($v), $ticks),
                'range' => [0, max($ceiling, $maximum * 1.08)], 'gridcolor' => '#edf0f4', 'griddash' => 'dot', 'zeroline' => false, 'fixedrange' => true],
        ]);
    }

    private function ranking(array $programs): array
    {
        $selected = array_values(array_filter($programs, fn ($p) => $p['registrations'] > 0 && $p['capacity'] > 0));
        usort($selected, fn ($a, $b) => ($b['registrations'] / $b['capacity'] <=> $a['registrations'] / $a['capacity']) ?: ($b['registrations'] <=> $a['registrations']) ?: strcmp($a['title'], $b['title']) ?: ($a['id'] <=> $b['id']));
        $selected = array_slice($selected, 0, 5);
        $ids = array_map(fn ($p) => (string) $p['id'], $selected);
        $rates = array_map(fn ($p) => $p['registrations'] / $p['capacity'] * 100, $selected);
        $annotations = $shapes = $custom = [];
        foreach ($selected as $index => $p) {
            $common = ['xref' => 'paper', 'yref' => 'y', 'y' => $index, 'yshift' => 19, 'yanchor' => 'bottom', 'showarrow' => false];
            $title = str_replace('&#039;', '&#x27;', htmlspecialchars($p['title'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
            $annotations[] = array_merge($common, ['x' => 0, 'xanchor' => 'left', 'align' => 'left', 'text' => $title, 'font' => ['size' => 13, 'color' => '#46353d']]);
            $annotations[] = array_merge($common, ['x' => 1, 'xanchor' => 'right', 'align' => 'right',
                'text' => '<b>'.number_format($p['registrations'], 0, ',', '.').' / '.number_format($p['capacity'], 0, ',', '.').'</b> · '.$this->decimalLabel($rates[$index]).'%',
                'font' => ['size' => 13, 'color' => '#823749']]);
            $shapes[] = ['type' => 'line', 'xref' => 'x', 'yref' => 'y', 'x0' => 0, 'x1' => 100, 'y0' => $index, 'y1' => $index, 'line' => ['color' => '#f5eef0', 'width' => 12], 'layer' => 'below'];
            $custom[] = [$p['id'], $title, $p['registrations'], $p['capacity'], round($rates[$index], 1, PHP_ROUND_HALF_EVEN)];
        }
        $shapes[] = ['type' => 'line', 'xref' => 'x', 'yref' => 'paper', 'x0' => 100, 'x1' => 100, 'y0' => 0, 'y1' => 1, 'line' => ['color' => '#cbb5bd', 'width' => 1, 'dash' => 'dot'], 'layer' => 'above'];
        $maximum = max(100, max($rates ?: [0]));
        $ticks = [0, 25, 50, 75, 100];
        if ($maximum >= 125) {
            $ticks[] = round($maximum, 1, PHP_ROUND_HALF_EVEN);
        }
        $chart = $this->figure([[
            'type' => 'bar', 'orientation' => 'h', 'x' => $rates, 'y' => $ids,
            'marker' => ['color' => array_slice(['#b92236', '#cb5365', '#d47786', '#dea0aa', '#e8bdc5'], 0, count($ids)), 'cornerradius' => 6],
            'width' => 0.18, 'customdata' => $custom,
            'hovertemplate' => '%{customdata[1]}<br>%{customdata[2]:,.0f} pendaftar / %{customdata[3]:,.0f} kapasitas<br>Keterisian: %{customdata[4]}%<extra></extra>',
        ]], ! $selected, [
            'showlegend' => false, 'dragmode' => false, 'margin' => ['l' => 24, 'r' => 24, 't' => 8, 'b' => 50],
            'annotations' => $annotations, 'shapes' => $shapes,
            'yaxis' => ['type' => 'category', 'categoryorder' => 'array', 'categoryarray' => $ids, 'range' => [count($ids) - 0.5, -0.95], 'showticklabels' => false, 'showgrid' => false, 'zeroline' => false, 'fixedrange' => true],
            'xaxis' => ['range' => [0, $maximum * 1.04], 'showticklabels' => true, 'showgrid' => false, 'zeroline' => false, 'fixedrange' => true,
                'tickvals' => $ticks, 'ticktext' => array_map(fn ($v) => str_replace('.', ',', (string) $v).'%', $ticks),
                'title' => ['text' => 'Pendaftar dibanding kapasitas program', 'standoff' => 12]],
        ]);
        if (! $selected && array_sum(array_column($programs, 'registrations'))) {
            $chart['layout']['annotations'][0]['text'] = 'Kapasitas program belum ditentukan';
        }

        return $chart;
    }
}
