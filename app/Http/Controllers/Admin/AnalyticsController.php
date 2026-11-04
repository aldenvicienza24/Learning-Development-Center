<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Registration;
use App\Services\DashboardAnalyticsService;
use App\Services\DashboardAnalyticsWorkbook;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $programs = Program::query()->orderBy('title')->get(['id', 'title', 'category']);

        return view('admin.analytics', [
            'analyticsPrograms' => $programs->map(fn (Program $program) => $program->only(['id', 'title', 'category']))->values(),
            'analyticsCategories' => $programs->pluck('category')->filter()->unique()->sort()->values(),
            'analyticsFirstDate' => substr((string) min(array_filter([
                Registration::query()->min('created_at'), Registration::query()->min('payment_received_at'), today()->toDateString(),
            ])), 0, 10),
        ]);
    }

    public function __invoke(Request $request, DashboardAnalyticsService $analytics): JsonResponse
    {
        $data = $this->validatedFilters($request);

        try {
            return response()->json($analytics->calculate($data))->header('Cache-Control', 'private, no-store');
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Analitik belum dapat dimuat. Coba lagi atau hubungi pengelola situs web.',
            ], 503)->header('Cache-Control', 'private, no-store');
        }
    }

    public function exportExcel(Request $request, DashboardAnalyticsService $analytics, DashboardAnalyticsWorkbook $workbook): StreamedResponse
    {
        $filters = $this->validatedFilters($request);
        $spreadsheet = $workbook->build($analytics->calculate($filters));
        $filename = "dashboard-uisi-{$filters['start_date']}-{$filters['end_date']}.xlsx";

        return response()->streamDownload(function () use ($spreadsheet): void {
            $writer = new Xlsx($spreadsheet);
            $writer->setIncludeCharts(true);
            $writer->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'private, no-store',
        ]);
    }

    private function validatedFilters(Request $request): array
    {
        $data = $request->validate([
            'start_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:2000-01-01'],
            'end_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:start_date', 'before_or_equal:today'],
            'program_id' => ['nullable', 'integer', Rule::exists('programs', 'id')],
            'category' => ['nullable', 'string', 'max:100', Rule::exists('programs', 'category')],
            'interval' => ['required', Rule::in(['day', 'week', 'month'])],
            'payment_status' => ['nullable', Rule::in(['menunggu_pembayaran', 'menunggu_verifikasi', 'disetujui', 'ditolak'])],
            'participant_status' => ['nullable', Rule::in(['menunggu_pembayaran', 'menunggu_verifikasi', 'diproses', 'diterima', 'ditolak'])],
        ]);

        if (! empty($data['program_id']) && ! Program::query()->whereKey($data['program_id'])
            ->when($data['category'] ?? null, fn ($query, $category) => $query->where('category', $category))
            ->exists()) {
            throw ValidationException::withMessages([
                'program_id' => 'Program tidak sesuai dengan kategori yang dipilih.',
            ]);
        }

        $start = CarbonImmutable::parse($data['start_date']);
        $end = CarbonImmutable::parse($data['end_date']);
        if ($start->diffInDays($end) > 3660) {
            throw ValidationException::withMessages([
                'start_date' => 'Pilih rentang tanggal maksimal 10 tahun.',
            ]);
        }

        return $data;
    }
}
