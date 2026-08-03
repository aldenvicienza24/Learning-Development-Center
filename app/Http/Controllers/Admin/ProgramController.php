<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $category = strtolower((string) $request->query('category', ''));
        $type = $request->query('type');

        $programs = Program::query()
            ->withCount('registrations')
            ->when($request->filled('status'), fn ($query) => $this->applyComputedStatusFilter($query, $request->status))
            ->when($category !== '', fn ($query) => $query->whereRaw('LOWER(category) = ?', [$category]))
            ->when($type === 'nasional', fn ($query) => $query->where('is_international', false))
            ->when($type === 'internasional', fn ($query) => $query->where('is_international', true))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.programs.index', [
            'programs' => $programs,
            'categories' => [
                'pelatihan' => 'Pelatihan',
                'sertifikasi' => 'Sertifikasi',
                'bahasa' => 'Bahasa',
            ],
        ]);
    }

    public function create()
    {
        return view('admin.programs.create', [
            'program' => new Program([
                'status' => 'coming_soon',
                'quota' => 30,
                'total_quota' => 30,
                'is_international' => false,
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data = $this->normalizeProgramDates($data);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('programs', 'public');
            $data['thumbnail'] = $path;
            $data['image_url'] = '/storage/'.$path;
        }

        $data['image_url'] = $data['image_url'] ?? 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&q=80';
        $data['detail_url'] = $data['detail_url'] ?: $this->nextDetailUrl();
        $data['slug'] = Program::uniqueSlug($data['title']);
        $data = $this->normalizeQuotaStatus($data);

        Program::create($data);

        return redirect()->route('admin.programs.index')->with('status', 'Program berhasil ditambahkan.');
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $data = $this->validatedData($request);
        $data = $this->normalizeProgramDates($data, $program);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('programs', 'public');
            $data['thumbnail'] = $path;
            $data['image_url'] = '/storage/'.$path;
        }

        if ($program->title !== $data['title']) {
            $data['slug'] = Program::uniqueSlug($data['title'], $program->id);
        }

        $data['image_url'] = $data['image_url'] ?? $program->image_url;
        $data['detail_url'] = $data['detail_url'] ?: $program->detail_url;
        $data = $this->normalizeQuotaStatus($data);

        $program->update($data);

        return redirect()->route('admin.programs.index')->with('status', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')->with('status', 'Program berhasil dihapus.');
    }

    private function applyComputedStatusFilter(Builder $query, string $status): void
    {
        if ($status === 'closed') {
            $query->where(fn ($inner) => $inner
                ->where('status', 'closed')
                ->orWhere('is_registration_closed', true)
                ->orWhere('quota', '<=', 0));

            return;
        }

        if ($status === 'coming_soon') {
            $query
                ->where('status', '!=', 'closed')
                ->where('is_registration_closed', false)
                ->where('quota', '>', 0)
                ->where(fn ($inner) => $inner
                    ->where('status', 'coming_soon')
                    ->orWhere(fn ($dateQuery) => $dateQuery
                        ->whereNotIn('status', ['open_registration', 'closed'])
                        ->whereDate('registration_open_date', '>', now())));

            return;
        }

        if ($status === 'open_registration') {
            $query
                ->where('status', 'open_registration')
                ->where('is_registration_closed', false)
                ->where('quota', '>', 0);
        }
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category' => ['required', 'string', 'max:80'],
            'faculty' => ['nullable', 'string', 'max:80'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'registration_start_date' => ['nullable', 'date'],
            'registration_end_date' => ['nullable', 'date', 'after_or_equal:registration_start_date'],
            'detail_url' => ['nullable', 'string', 'max:120'],
            'description' => ['required', 'string'],
            'syllabus' => ['required', 'string', 'max:500'],
            'price' => [
                'required',
                'integer',
                'min:0',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if ((int) $value % 50000 !== 0) {
                        $fail('Harga harus menggunakan kelipatan Rp50.000.');
                    }
                },
            ],
            'total_quota' => ['required', 'integer', 'min:1'],
            'quota' => ['required', 'integer', 'min:0', 'lte:total_quota'],
            'status' => ['required', 'in:coming_soon,open_registration,closed'],
            'is_registration_closed' => ['nullable', 'boolean'],
            'is_international' => ['required', 'boolean'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ]) + ['is_registration_closed' => false];
    }

    private function normalizeProgramDates(array $data, ?Program $program = null): array
    {
        $startDate = $data['registration_start_date'] ?? null;
        $endDate = $data['registration_end_date'] ?? null;

        unset($data['registration_start_date'], $data['registration_end_date']);

        if ($startDate && $endDate) {
            $data['registration_date'] = $this->formatRegistrationPeriod($startDate, $endDate);
            $data['registration_open_date'] = $startDate;
            $data['event_date'] = $endDate;

            return $data;
        }

        if ($program) {
            $data['registration_date'] = $program->registration_date;
            $data['registration_open_date'] = $program->registration_open_date;
            $data['event_date'] = $program->event_date;

            return $data;
        }

        $today = now()->toDateString();
        $data['registration_date'] = 'Belum dijadwalkan';
        $data['registration_open_date'] = $today;
        $data['event_date'] = $today;

        return $data;
    }

    private function normalizeQuotaStatus(array $data): array
    {
        $data['quota'] = max(0, (int) $data['quota']);
        $data['total_quota'] = max((int) $data['total_quota'], $data['quota']);

        if ($data['quota'] <= 0) {
            $data['quota'] = 0;
            $data['status'] = 'closed';
            $data['is_registration_closed'] = true;

            return $data;
        }

        if (($data['status'] ?? null) === 'closed') {
            $data['is_registration_closed'] = true;

            return $data;
        }

        $data['is_registration_closed'] = false;

        return $data;
    }

    private function nextDetailUrl(): string
    {
        $nextId = ((int) Program::query()->max('id')) + 1;
        $detailUrl = 'detail'.$nextId;

        while (Program::query()->where('detail_url', $detailUrl)->exists()) {
            $nextId++;
            $detailUrl = 'detail'.$nextId;
        }

        return $detailUrl;
    }

    private function formatRegistrationPeriod(string $startDate, string $endDate): string
    {
        $start = Carbon::parse($startDate)->locale('id');
        $end = Carbon::parse($endDate)->locale('id');

        if ($start->isSameDay($end)) {
            return $start->translatedFormat('d M Y');
        }

        if ($start->isSameMonth($end) && $start->isSameYear($end)) {
            return $start->format('d').' - '.$end->translatedFormat('d M');
        }

        if ($start->isSameYear($end)) {
            return $start->translatedFormat('d M').' - '.$end->translatedFormat('d M');
        }

        return $start->translatedFormat('d M Y').' - '.$end->translatedFormat('d M Y');
    }
}