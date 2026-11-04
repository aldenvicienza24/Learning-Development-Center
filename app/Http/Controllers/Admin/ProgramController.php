<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Services\ProgramSeatService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function __construct(private ProgramSeatService $seats) {}

    public function index()
    {
        $this->seats->releaseExpired();

        $programs = Program::query()
            ->withCount('registrations')
            ->latest()
            ->paginate(10);

        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create', [
            'program' => new Program([
                'status' => 'coming_soon',
                'quota' => 30,
                'total_quota' => 30,
            ]),
            'allTrainers' => \App\Models\Trainer::all(),
        ]);
    }

    public function show(Request $request, Program $program)
    {
        $this->seats->releaseExpired();

        $program->refresh();
        $program->loadCount('registrations');

        $participantSearch = trim((string) $request->query('participant_search', ''));

        $registrations = $program->registrations()
            ->when($participantSearch !== '', function ($query) use ($participantSearch) {
                $query->where(function ($query) use ($participantSearch) {
                    $query->where('full_name', 'like', '%'.$participantSearch.'%')
                        ->orWhere('email', 'like', '%'.$participantSearch.'%')
                        ->orWhere('phone', 'like', '%'.$participantSearch.'%')
                        ->orWhere('institution', 'like', '%'.$participantSearch.'%')
                        ->orWhere('participant_status', 'like', '%'.$participantSearch.'%')
                        ->orWhere('payment_status', 'like', '%'.$participantSearch.'%')
                        ->orWhere('status', 'like', '%'.$participantSearch.'%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $statusCounts = $program->registrations()
            ->selectRaw("COALESCE(NULLIF(participant_status, ''), status, 'menunggu_verifikasi') as status_key, COUNT(*) as total")
            ->groupBy('status_key')
            ->pluck('total', 'status_key');

        return view('admin.programs.show', compact('program', 'registrations', 'statusCounts', 'participantSearch'));
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
        $data['detail_url'] = ($data['detail_url'] ?? null) ?: $this->nextDetailUrl();
        $data['slug'] = Program::uniqueSlug($data['title']);
        $data = $this->normalizeQuotaStatus($data);

        $program = Program::create($data);
        
        if (isset($data['trainers'])) {
            $program->trainers()->sync($data['trainers']);
        }

        return redirect()->route('admin.programs.index')->with('status', 'Program berhasil ditambahkan.');
    }

    public function edit(Program $program)
    {
        $this->seats->releaseExpired();

        $program->refresh();
        $allTrainers = \App\Models\Trainer::all();

        return view('admin.programs.edit', compact('program', 'allTrainers'));
    }

    public function update(Request $request, Program $program)
    {
        $this->seats->releaseExpired();

        $program->refresh();
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
        $data = $this->normalizeQuotaStatus($data, $program);

        $program->update($data);
        
        if (isset($data['trainers'])) {
            $program->trainers()->sync($data['trainers']);
        } else {
            $program->trainers()->sync([]);
        }

        return redirect()->route('admin.programs.index')->with('status', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')->with('status', 'Program berhasil dihapus.');
    }

    public function duplicate(Program $program)
    {
        $newProgram = $program->replicate();
        
        $newProgram->title = $program->title; // Tetap sama, tidak ada embel-embel (Copy) agar tidak terlihat publik jika lupa dihapus
        $newProgram->slug = Program::uniqueSlug($program->title);
        $newProgram->detail_url = strtolower(str_replace('-', '', substr($newProgram->slug, 0, 10)) . rand(100, 999));
        $newProgram->show_in_offer = false; // Sembunyikan dari penawaran utama sementara admin mengedit
        
        $newProgram->save();

        return redirect()->route('admin.programs.edit', $newProgram)->with('status', 'Program berhasil diduplikasi. Silakan perbarui tanggal pendaftaran dan pelaksanaan.');
    }

    public function sendTestimonialEmails(Request $request, Program $program)
    {
        // Cek apakah tanggal pelaksanaan sudah lewat
        if (now()->lessThanOrEqualTo($program->execution_date ?? $program->event_date)) {
            return back()->with('status', 'Gagal! Form testimoni hanya bisa dikirim setelah program selesai dilaksanakan.');
        }

        $pesertaApproved = $program->registrations()
            ->where('status', 'disetujui') // Or whatever the approved status is
            ->get();

        if ($pesertaApproved->isEmpty()) {
            return back()->with('status', 'Tidak ada peserta yang disetujui untuk program ini.');
        }

        foreach ($pesertaApproved as $peserta) {
            $token = \Illuminate\Support\Str::uuid();
            
            \App\Models\Testimonial::create([
                'program_id' => $program->id,
                'registration_id' => $peserta->id,
                'token' => $token,
                'status' => 'pending',
                'is_submitted' => false,
            ]);

            \Illuminate\Support\Facades\Mail::to($peserta->email)->queue(new \App\Mail\TestimonialMail($token, $program));
        }

        return back()->with('status', 'Email form testimoni sedang dikirim ke seluruh peserta terdaftar yang disetujui!');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category' => ['required', 'string', 'max:80'],
            'faculty' => ['required', 'string', 'max:120'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'registration_start_date' => ['nullable', 'date'],
            'registration_end_date' => ['nullable', 'date', 'after_or_equal:registration_start_date'],
            'execution_date' => ['nullable', 'date'],
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
            'quota' => ['required', 'integer', 'min:0'],
            'is_registration_closed' => ['nullable', 'boolean'],
            'show_in_offer' => ['nullable', 'boolean'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048', 'dimensions:max_width=2400,max_height=3000'],
            'trainers' => ['nullable', 'array'],
            'trainers.*' => ['exists:trainers,id'],
        ]) + ['is_registration_closed' => false, 'show_in_offer' => false, 'status' => 'open_registration'];
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

    private function normalizeQuotaStatus(array $data, ?Program $program = null): array
    {
        $data['quota'] = max(0, (int) $data['quota']);
        $reservedSeats = $program ? $this->reservedSeatCount($program) : 0;
        $data['total_quota'] = $data['quota'] + $reservedSeats;

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

    private function reservedSeatCount(Program $program): int
    {
        return $program->registrations()
            ->where('seat_reserved', true)
            ->count();
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
