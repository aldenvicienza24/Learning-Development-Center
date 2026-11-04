<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Registration;
use App\Models\Testimonial;
use App\Models\WebsiteSetting;
use App\Services\ProgramSeatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function __construct(private ProgramSeatService $seats) {}

    public function index(Request $request)
    {
        $filters = $request->validate(['testimonial_program' => ['nullable', 'integer', 'exists:programs,id']]);
        $this->cleanupExpiredRegistrations();

        $allPrograms = Program::query()
            ->with('trainers:id,name,photo')
            ->withCount('registrations')
            ->get();
        $programs = $allPrograms
            ->filter(fn (Program $program) => $program->computed_status === 'open_registration')
            ->values();
        $comingSoonPrograms = $allPrograms
            ->filter(fn (Program $program) => $program->computed_status === 'coming_soon')
            ->values();
        $faculties = $this->faculties($programs);
        $settings = WebsiteSetting::allAsArray();

        $testimonialPrograms = Program::whereHas('testimonials', fn ($query) => $query->published())
            ->orderBy('title')->get(['id', 'title']);
        $testimonials = Testimonial::published()->with('program:id,title,slug')
            ->when($filters['testimonial_program'] ?? null, fn ($query, $id) => $query->where('program_id', $id))
            ->latest('id')->get();

        $dashboardStatistics = [
            'total_programs' => $allPrograms->count(),
            'total_registrations' => Registration::query()
                ->whereRaw("COALESCE(NULLIF(participant_status, ''), status, 'menunggu_verifikasi') != 'ditolak'")
                ->count(),
            'total_trainers' => (isset($settings['total_trainers']) && (int) $settings['total_trainers'] > 0)
                ? (int) $settings['total_trainers']
                : \App\Models\Trainer::count(),
            'coming_soon_programs' => $comingSoonPrograms->count(),
        ];

        return view('dashboard', compact('programs', 'comingSoonPrograms', 'faculties', 'settings', 'testimonials', 'testimonialPrograms', 'dashboardStatistics'));
    }

    public function programs()
    {
        $this->cleanupExpiredRegistrations();

        $allPrograms = Program::query()
            ->with('trainers:id,name,photo')
            ->withCount('registrations')
            ->get();
        $programs = $allPrograms
            ->filter(fn (Program $program) => $program->computed_status === 'open_registration')
            ->values();
        $comingSoonPrograms = $allPrograms
            ->filter(fn (Program $program) => $program->computed_status === 'coming_soon')
            ->values();

        return view('program1', [
            'programs' => $programs,
            'comingSoonPrograms' => $comingSoonPrograms,
            'faculties' => $this->faculties($programs),
            'programQuotas' => $this->programQuotaMap($allPrograms),
        ]);
    }

    public function show(Program $program)
    {
        $this->cleanupExpiredRegistrations();

        $program->refresh();
        $program->loadCount('registrations');

        return view('program-detail', [
            'program' => $program,
        ]);
    }

    public function registration(Request $request)
    {
        $this->cleanupExpiredRegistrations();

        $programs = Program::withCount('registrations')
            ->get()
            ->filter(fn (Program $program) => $program->computed_status === 'open_registration')
            ->values();
        $selectedProgramReference = trim((string) $request->query('id', ''));
        $selectedProgram = $selectedProgramReference === ''
            ? null
            : $programs->first(fn (Program $program) => (string) $program->id === $selectedProgramReference
                || (string) $program->slug === $selectedProgramReference
                || (string) $program->detail_url === $selectedProgramReference
            );
        $registrationBackUrl = route('dashboard');
        $requestedReturnUrl = trim((string) $request->query('return_to', ''));

        if ($requestedReturnUrl !== '') {
            $returnUrlParts = parse_url($requestedReturnUrl);
            if (is_array($returnUrlParts)) {
                $returnUrlHost = strtolower((string) ($returnUrlParts['host'] ?? ''));
                $returnUrlPath = (string) ($returnUrlParts['path'] ?? '');
                $returnUrlScheme = strtolower((string) ($returnUrlParts['scheme'] ?? ''));
                $isInternalHost = $returnUrlHost === '' || $returnUrlHost === strtolower($request->getHost());
                $isSafeScheme = $returnUrlScheme === '' || in_array($returnUrlScheme, ['http', 'https'], true);

                if ($isSafeScheme && $isInternalHost && str_starts_with($returnUrlPath, '/')) {
                    $registrationBackUrl = $requestedReturnUrl;
                }
            }
        }
        $whatsappSetting = trim((string) WebsiteSetting::getValue('whatsapp', ''));
        $customClassWhatsappNumber = preg_replace('/\D+/', '', $whatsappSetting ?: '+62 858-0069-5077');

        if (str_starts_with($customClassWhatsappNumber, '0')) {
            $customClassWhatsappNumber = '62'.substr($customClassWhatsappNumber, 1);
        } elseif (str_starts_with($customClassWhatsappNumber, '8')) {
            $customClassWhatsappNumber = '62'.$customClassWhatsappNumber;
        }
        $customClassWhatsappUrl = 'https://api.whatsapp.com/send?phone='.$customClassWhatsappNumber
            .'&text='.rawurlencode('Halo, saya ingin bertanya, apakah tersedia kelas khusus?');

        return response()
            ->view('pendaftaran', [
                'programsData' => $this->registrationProgramMap($programs),
                'partnerDiscounts' => \App\Models\PartnerDiscount::query()->where('is_active', true)->get(['id', 'institution_name', 'email_domain', 'discount_percentage', 'program_id']),
                'registrationBackUrl' => $registrationBackUrl,
                'customClassWhatsappNumber' => $customClassWhatsappNumber,
                'customClassWhatsappUrl' => $customClassWhatsappUrl,
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function search(Request $request)
    {
        $this->cleanupExpiredRegistrations();

        $query = Str::of((string) $request->query('q', ''))
            ->squish()
            ->limit(80, '')
            ->toString();

        if (mb_strlen($query) < 2) {
            return response()->json(['programs' => []]);
        }

        $terms = collect(preg_split('/\s+/u', $query, -1, PREG_SPLIT_NO_EMPTY))
            ->take(5);
        $english = $request->query('lang') === 'en';

        $programs = Program::query()
            ->withCount('registrations')
            ->where(function ($builder) use ($terms) {
                foreach ($terms as $term) {
                    $builder->where(function ($termQuery) use ($term) {
                        $pattern = '%'.addcslashes($term, '%_\\').'%';

                        $termQuery
                            ->where('title', 'like', $pattern)
                            ->orWhere('category', 'like', $pattern)
                            ->orWhere('faculty', 'like', $pattern)
                            ->orWhere('description', 'like', $pattern);
                    });
                }
            })
            ->latest('id')
            ->limit(20)
            ->get()
            ->filter(fn (Program $program) => $program->computed_status !== 'closed')
            ->take(8)
            ->values()
            ->map(function (Program $program) use ($english) {
                $status = match ($program->computed_status) {
                    'coming_soon' => $english ? 'Coming soon' : 'Segera dibuka',
                    default => $english ? 'Registration open' : 'Pendaftaran dibuka',
                };

                return [
                    'title' => $program->title,
                    'meta' => $program->categoryFacultyLabel($english),
                    'status' => $status,
                    'url' => route('program.show', $program),
                ];
            });

        return response()
            ->json(['programs' => $programs])
            ->header('Cache-Control', 'private, max-age=30');
    }

    public function storeRegistration(Request $request)
    {
        $this->cleanupExpiredRegistrations();

        $data = $request->validate([
            'program_id' => ['required', 'string'],
            'full_name' => ['required', 'string', 'max:180'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:9', 'max:15'],
            'institution' => ['required', 'string', 'max:180'],
        ], [
            'phone.regex' => 'Nomor WhatsApp hanya boleh berisi angka.',
            'phone.min' => 'Nomor WhatsApp minimal terdiri dari 9 angka.',
            'phone.max' => 'Nomor WhatsApp maksimal terdiri dari 15 angka.',
        ]);

        $visitorId = $request->session()->get('visitor_id');

        try {
            $registration = DB::transaction(function () use ($data, $visitorId) {
                $program = $this->programReferenceQuery($data['program_id'])
                    ->lockForUpdate()
                    ->first();

                if (! $program || $program->computed_status !== 'open_registration') {
                    return null;
                }

                $existingRegistration = Registration::query()
                    ->where('program_id', $program->id)
                    ->where('email', $data['email'])
                    ->where('status', '!=', 'ditolak')
                    ->first();

                if ($existingRegistration) {
                    if ($existingRegistration->status === 'menunggu_pembayaran' && now()->lessThan($existingRegistration->created_at->addMinutes(15))) {
                        return [
                            'pending_payment' => true,
                            'registration_id' => $existingRegistration->id,
                        ];
                    }

                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'email' => 'Email ini sudah terdaftar pada program ini. Silakan gunakan email lain atau cek status pendaftaran Anda.'
                    ]);
                }

                if (! $this->seats->reserve($program)) {
                    return null;
                }

                $partnerDiscount = \App\Models\PartnerDiscount::findDiscountForEmail($data['email'], $program->id);
                $discountPercentage = $partnerDiscount ? $partnerDiscount->discount_percentage : 0;
                $originalPrice = max(0, (int) $program->price);
                $discountAmount = (int) round(($originalPrice * $discountPercentage) / 100);
                $finalPrice = max(0, $originalPrice - $discountAmount);

                $registrationData = [
                    'program_id' => $program->id,
                    'visitor_id' => $visitorId,
                    'full_name' => $data['full_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'institution' => $data['institution'],
                    'partner_discount_id' => $partnerDiscount?->id,
                    'discount_percentage' => $discountPercentage,
                    'discount_amount' => $discountAmount,
                    'final_price' => $finalPrice,
                    'participant_status' => 'menunggu_pembayaran',
                    'payment_status' => 'menunggu_pembayaran',
                    'status' => 'menunggu_pembayaran',
                ];

                if ($this->seats->tracksReservationState()) {
                    $registrationData['seat_reserved'] = true;
                }

                $registration = Registration::create($registrationData);

                return $registration->load('program');
            });
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'ok' => false,
                'message' => collect($exception->errors())->flatten()->first(),
                'message_en' => collect($exception->errors())->flatten()->first(),
                'validation_error' => true,
            ], 422);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'ok' => false,
                'message' => 'Pendaftaran gagal disimpan. Silakan coba lagi.',
                'message_en' => 'Registration could not be saved. Please try again.',
            ], 500);
        }

        if (is_array($registration) && isset($registration['pending_payment'])) {
            return response()->json([
                'ok' => false,
                'pending_payment' => true,
                'registration_id' => $registration['registration_id'],
                'message' => 'Anda memiliki pembayaran yang belum diselesaikan. Mengalihkan ke halaman pembayaran...',
                'message_en' => 'You have an incomplete payment. Redirecting to payment page...',
            ]);
        }

        if (! $registration) {
            return response()->json([
                'ok' => false,
                'message' => 'Kuota program sudah habis atau pendaftaran ditutup.',
                'message_en' => 'The program is fully booked or registration has closed.',
            ], 409);
        }

        // Delayed reminders need a persistent queue, including local setups using sync.
        $reminderConnection = config('queue.default') === 'sync' ? 'database' : config('queue.default');
        foreach ([10, 5] as $remainingMinutes) {
            \App\Jobs\SendPaymentReminderJob::dispatch($registration, $remainingMinutes)
                ->onConnection($reminderConnection)
                ->onQueue('payment-reminders')
                ->delay($registration->created_at->copy()->addMinutes(15 - $remainingMinutes))
                ->afterCommit();
        }

        return response()->json([
            'ok' => true,
            'registration_id' => $registration->id,
            'quota' => $registration->program->remaining_quota,
            'message' => 'Pendaftaran berhasil disimpan dan kursi diamankan selama 15 menit.',
            'message_en' => 'Registration was saved and your seat is reserved for 15 minutes.',
        ]);
    }

    public function faculty(string $slug)
    {
        $this->cleanupExpiredRegistrations();

        $allPrograms = Program::query()->get();

        $programs = $allPrograms
            ->filter(fn (Program $program) => $this->programFacultySlug($program) === $slug
                && $program->computed_status !== 'closed'
                && $program->computed_status !== 'coming_soon'
            )
            ->values();
        $comingSoonPrograms = $allPrograms
            ->filter(fn (Program $program) => $this->programFacultySlug($program) === $slug
                && $program->computed_status === 'coming_soon'
            )
            ->values();

        $faculties = $this->faculties(
            $allPrograms->filter(fn (Program $program) => $program->computed_status === 'open_registration')
        );
        $faculty = collect($faculties)->firstWhere('slug', $slug);

        abort_if(! $faculty, 404);

        return view('faculty', compact('faculty', 'faculties', 'programs', 'comingSoonPrograms'));
    }

    public function decrementQuota(Request $request)
    {
        $this->cleanupExpiredRegistrations();

        $data = $request->validate([
            'program_id' => ['required', 'string'],
        ]);

        $program = $this->programReferenceQuery($data['program_id'])->firstOrFail();

        return response()->json([
            'ok' => true,
            'quota' => $program->remaining_quota,
            'message' => 'Kursi langsung diamankan setelah formulir berhasil dikirim.',
            'message_en' => 'The seat is reserved as soon as the form is submitted successfully.',
        ]);
    }

    public function payment(Request $request, Registration $registration)
    {
        $this->cleanupExpiredRegistrations();

        $registration->load(['program', 'partnerDiscount']);

        // Jika sudah kedaluwarsa (sudah dibersihkan)
        if ($registration->status === 'expired') {
            return redirect()->route('pendaftaran')->with('error', 'Waktu pembayaran Anda telah habis (lebih dari 15 menit). Silakan mendaftar ulang.');
        }

        // Pendaftaran yang sudah dibatalkan tidak boleh membuka kembali halaman pembayaran.
        if ($registration->status === 'ditolak') {
            $registrationQuery = ['id' => $registration->program_id];

            if ($request->filled('return_to')) {
                $registrationQuery['return_to'] = $request->query('return_to');
            }

            return redirect()->route('pendaftaran', $registrationQuery);
        }

        // Jika statusnya bukan menunggu_pembayaran
        if ($registration->status !== 'menunggu_pembayaran') {
            return redirect()->route('dashboard');
        }

        $expiresAt = $registration->created_at->addMinutes(15);

        if (now()->greaterThanOrEqualTo($expiresAt)) {
            $this->cleanupExpiredRegistrations(); // Pastikan bersih

            return redirect()->route('pendaftaran')->with('error', 'Waktu pembayaran Anda telah habis (lebih dari 15 menit). Silakan mendaftar ulang.');
        }

        $restartRegistrationQuery = ['id' => $registration->program_id];
        if ($request->filled('return_to')) {
            $restartRegistrationQuery['return_to'] = $request->query('return_to');
        }

        return response()
            ->view('pembayaran', [
                'registration' => $registration,
                'program' => $registration->program,
                'expiresAt' => $expiresAt,
                'now' => now(),
                'restartRegistrationUrl' => route('pendaftaran', $restartRegistrationQuery, false),
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function storePayment(Request $request, Registration $registration)
    {
        $this->cleanupExpiredRegistrations();

        if ($registration->status !== 'menunggu_pembayaran') {
            return response()->json([
                'ok' => false,
                'message' => 'Pendaftaran ini tidak valid atau sudah kedaluwarsa.',
                'message_en' => 'This registration is invalid or has expired.',
            ], 400);
        }

        $data = $request->validate([
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [
            'payment_proof.max' => 'Bukti pembayaran terlalu besar. Ukuran maksimal 2 MB. Kompres berkas atau pilih berkas yang lebih kecil, lalu unggah kembali.',
            'payment_proof.uploaded' => 'Bukti pembayaran gagal diunggah. Pastikan ukuran berkas maksimal 2 MB, lalu coba kembali.',
            'payment_proof.required' => 'Pilih bukti pembayaran terlebih dahulu.',
            'payment_proof.mimes' => 'Format bukti pembayaran harus JPG, PNG, atau PDF.',
        ]);

        $proofPath = null;

        try {
            $result = DB::transaction(function () use ($request, $registration, &$proofPath): string {
                $lockedRegistration = Registration::query()
                    ->whereKey($registration->getKey())
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($lockedRegistration->status !== 'menunggu_pembayaran') {
                    return 'invalid';
                }

                if (now()->greaterThanOrEqualTo($lockedRegistration->created_at->addMinutes(15))) {
                    $this->seats->syncForStatus($lockedRegistration, 'ditolak');
                    $lockedRegistration->update([
                        'status' => 'ditolak',
                        'participant_status' => 'ditolak',
                        'payment_status' => 'ditolak',
                    ]);

                    return 'expired';
                }

                if (! $this->seats->syncForStatus($lockedRegistration, 'menunggu_verifikasi')) {
                    return 'full';
                }

                $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

                $lockedRegistration->update([
                    'payment_proof' => $proofPath,
                    'participant_status' => 'menunggu_verifikasi',
                    'payment_status' => 'menunggu_verifikasi',
                    'status' => 'menunggu_verifikasi',
                ]);

                return 'reserved';
            });

            if ($result === 'invalid') {
                return response()->json([
                    'ok' => false,
                    'message' => 'Pendaftaran ini tidak valid atau sudah kedaluwarsa.',
                    'message_en' => 'This registration is invalid or has expired.',
                ], 400);
            }

            if ($result === 'full') {
                return response()->json([
                    'ok' => false,
                    'message' => 'Maaf, kuota telah diambil peserta lain sebelum pembayaran Anda dikirim.',
                    'message_en' => 'Sorry, the last seat was taken before your payment was submitted.',
                ], 409);
            }

            if ($result === 'expired') {
                return response()->json([
                    'ok' => false,
                    'message' => 'Waktu pembayaran telah habis. Kursi dikembalikan ke kuota program.',
                    'message_en' => 'The payment window has expired. Your seat was returned to program availability.',
                ], 410);
            }

            return response()->json([
                'ok' => true,
                'message' => 'Bukti pembayaran berhasil diunggah dan kursi Anda tetap aman.',
                'message_en' => 'Payment proof was uploaded and your seat remains reserved.',
            ]);
        } catch (\Throwable $exception) {
            if ($proofPath) {
                Storage::disk('public')->delete($proofPath);
            }

            report($exception);

            return response()->json([
                'ok' => false,
                'message' => 'Gagal mengunggah bukti pembayaran. Silakan coba lagi.',
                'message_en' => 'Payment proof could not be uploaded. Please try again.',
            ], 500);
        }
    }

    public function cancelPayment(Registration $registration)
    {
        $this->cleanupExpiredRegistrations();

        if ($registration->status !== 'menunggu_pembayaran') {
            return response()->json([
                'ok' => false,
                'message' => 'Hanya pendaftaran yang belum dibayar yang bisa dibatalkan.',
                'message_en' => 'Only unpaid registrations can be canceled.',
            ], 400);
        }

        $cancelled = DB::transaction(function () use ($registration): bool {
            $lockedRegistration = Registration::query()
                ->whereKey($registration->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedRegistration->status !== 'menunggu_pembayaran') {
                return false;
            }

            $this->seats->syncForStatus($lockedRegistration, 'ditolak');
            $lockedRegistration->update([
                'status' => 'ditolak',
                'participant_status' => 'ditolak',
                'payment_status' => 'ditolak',
            ]);

            return true;
        });

        if (! $cancelled) {
            return response()->json([
                'ok' => false,
                'message' => 'Pendaftaran ini sudah diproses atau sudah kedaluwarsa.',
                'message_en' => 'This registration has already been processed or expired.',
            ], 400);
        }

        return response()->json([
            'ok' => true,
            'message' => 'Pendaftaran dibatalkan dan kursi dikembalikan ke kuota program.',
            'message_en' => 'The registration was canceled and the seat was returned to program availability.',
        ]);
    }

    private function cleanupExpiredRegistrations()
    {
        $this->seats->releaseExpired();
    }

    private function faculties($programs = null): array
    {
        $programs ??= Program::all();

        $items = [
                [
                    'slug' => 'ekonomi-bisnis',
                    'code' => 'FEB',
                    'name' => 'Ekonomi dan Bisnis',
                    'subtitle' => 'Bisnis, manajemen, keuangan, pemasaran, risiko, dan tata kelola organisasi.',
                    'about' => 'Fakultas Ekonomi dan Bisnis berfokus pada penguatan kompetensi bisnis dan profesional agar peserta siap membaca peluang, mengelola risiko, dan mengambil keputusan berbasis data.',
                    'classes' => ['Kelas Bisnis dan Manajemen', 'Kelas Keuangan dan Risiko', 'Kelas Pemasaran dan Penjualan'],
                    'icon' => 'finance',
                ],
                [
                    'slug' => 'teknik-industri',
                    'code' => 'FTI',
                    'name' => 'Teknik Industri',
                    'subtitle' => 'Sistem industri, manufaktur, optimasi proses, manajemen proyek, dan mutu operasional.',
                    'about' => 'Fakultas Teknik Industri menghubungkan kemampuan teknis dengan manajemen operasi, sehingga peserta mampu memperbaiki proses, produktivitas, dan kualitas kerja industri.',
                    'classes' => ['Kelas Operasi dan Rantai Pasok', 'Kelas Mutu dan Produktivitas', 'Kelas Proyek dan Manufaktur'],
                    'icon' => 'industry',
                ],
                [
                    'slug' => 'teknologi-kreatif',
                    'code' => 'FTK',
                    'name' => 'Teknologi Kreatif',
                    'subtitle' => 'Desain digital, komunikasi visual, teknologi terapan, dan pemasaran kreatif.',
                    'about' => 'Fakultas Teknologi Kreatif menyiapkan peserta untuk menguasai keterampilan digital, komunikasi visual, desain, dan teknologi terapan yang relevan untuk kebutuhan industri kreatif.',
                    'classes' => ['Kelas Desain dan Digital', 'Kelas Pemasaran Kreatif', 'Kelas Teknologi Terapan'],
                    'icon' => 'creative',
                ],
                [
                    'slug' => 'bahasa',
                    'code' => 'BHS',
                    'name' => 'Bahasa',
                    'subtitle' => 'Persiapan TOEFL, IELTS, komunikasi profesional, dan bahasa untuk studi lanjut.',
                    'about' => 'Fakultas Bahasa berfokus pada penguatan kemampuan bahasa, persiapan tes, dan komunikasi profesional untuk kebutuhan akademik, karier, dan beasiswa.',
                    'classes' => ['Kelas Persiapan TOEFL', 'Kelas Persiapan IELTS', 'Kelas Komunikasi Profesional'],
                    'icon' => 'language',
                ],
        ];

        return collect($items)
            ->map(function ($faculty) use ($programs) {
                $facultyPrograms = $programs->filter(
                    fn (Program $program) => strtolower((string) $program->faculty) === $faculty['slug']
                );
                $faculty['program_count'] = $facultyPrograms->count();
                $faculty['categories'] = $facultyPrograms->pluck('category')->unique()->values()->all();

                return $faculty;
            })
            ->values()
            ->all();
    }

    private function programQuotaMap($programs): array
    {
        return $programs
            ->mapWithKeys(fn (Program $program) => [
                (string) $program->id => [
                    'quota' => $program->quota,
                    'total_quota' => $program->total_quota,
                ],
            ])
            ->all();
    }

    private function registrationProgramMap($programs): array
    {
        $map = [];

        foreach ($programs as $program) {
            $data = [
                'id' => (string) $program->id,
                'name' => $program->title,
                'category' => $this->programDisplayCategory($program),
                'categoryId' => $this->programDisplayCategory($program, false),
                'categoryEn' => $this->programDisplayCategory($program, true),
                'price' => $program->price,
                'date' => $program->registration_date,
                'method' => 'Daring',
                'quota' => $program->remaining_quota,
                'totalQuota' => $program->total_quota,
                'about' => filled($program->description) ? $program->description : null,
                'syllabusUrl' => filled($program->syllabus) ? $program->syllabus : null,
            ];

            $map[(string) $program->id] = $data;
        }

        return $map;
    }

    private function programDisplayCategory(Program $program, ?bool $english = null): string
    {
        $english ??= false;
        $faculties = $english
            ? [
                'ekonomi-bisnis' => 'Economics and Business',
                'teknik-industri' => 'Industrial Technology',
                'teknologi-kreatif' => 'Creative Technology',
                'bahasa' => 'Language Studies',
            ]
            : [
                'ekonomi-bisnis' => 'Ekonomi dan Bisnis',
                'teknik-industri' => 'Teknik Industri',
                'teknologi-kreatif' => 'Teknologi Kreatif',
                'bahasa' => 'Bahasa',
            ];

        $categories = $english
            ? [
                'pelatihan' => 'Professional Training',
                'sertifikasi' => 'Certification',
                'bahasa' => 'Language Program',
            ]
            : [
                'pelatihan' => 'Pelatihan',
                'sertifikasi' => 'Sertifikasi',
                'bahasa' => 'Bahasa',
            ];

        $faculty = $faculties[$this->programFacultySlug($program)] ?? $this->headlineLabel($program->faculty ?: 'Program');
        $category = $categories[strtolower((string) $program->category)] ?? $this->headlineLabel($program->category ?: 'Program');

        return $category === $faculty ? $category : "{$faculty} - {$category}";
    }

    private function headlineLabel(string $value): string
    {
        return ucwords(str_replace(['-', '_'], ' ', strtolower(trim($value))));
    }

    private function programReferenceQuery(string $reference)
    {
        abort_unless(preg_match('/^[A-Za-z0-9_-]+$/', $reference), 404);

        return Program::query()->where(function ($query) use ($reference) {
            if (ctype_digit($reference)) {
                $query->whereKey((int) $reference);

                return;
            }

            $query->where('slug', $reference)
                ->orWhere('detail_url', $reference);
        });
    }

    private function programFacultySlug(Program $program): string
    {
        $faculty = $program->faculty;

        if (in_array($faculty, ['ekonomi-bisnis', 'teknik-industri', 'teknologi-kreatif', 'bahasa'], true)) {
            return $faculty;
        }

        $title = strtolower($program->title);
        $category = strtolower($program->category);

        if ($category === 'bahasa'
            || str_contains($title, 'toefl')
            || str_contains($title, 'ielts')
            || str_contains($title, 'language')
            || str_contains($title, 'bahasa')
        ) {
            return 'bahasa';
        }

        if (str_contains($title, 'perpajakan')
            || str_contains($title, 'asuransi')
            || str_contains($title, 'marketing')
            || str_contains($title, 'bisnis')
        ) {
            return 'ekonomi-bisnis';
        }

        if (str_contains($title, 'autocad')
            || str_contains($title, 'proyek')
            || str_contains($title, 'manajemen proyek')
            || str_contains($title, 'industri')
        ) {
            return 'teknik-industri';
        }

        return 'teknologi-kreatif';
    }
}
