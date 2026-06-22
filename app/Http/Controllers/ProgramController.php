<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Program;

class ProgramController extends Controller
{
    private const PROGRAM_CARD_IDS = [
        '1' => 'detail1',
        '2' => 'detail2',
        '3' => 'detail3',
        '4' => 'detail4',
        '5' => 'detail5',
        '6' => 'detail7',
        '7' => 'detail6',
        'a' => 'detaila',
        'b' => 'detailb',
    ];

    public function index()
    {
        $programs = Program::all();
        $faculties = $this->faculties($programs);

        return view('dashboard', compact('programs', 'faculties'));
    }

    public function nationalPrograms()
    {
        $programs = Program::all();

        return view('program1', [
            'programs' => $programs,
            'faculties' => $this->faculties($programs),
            'programQuotas' => $this->programQuotaMap($programs),
        ]);
    }

    public function internationalPrograms()
    {
        $programs = Program::all();

        return view('program2', [
            'programs' => $programs,
            'faculties' => $this->faculties($programs),
            'programQuotas' => $this->programQuotaMap($programs),
        ]);
    }

    public function registration()
    {
        $programs = Program::all();

        return view('pendaftaran', [
            'programsData' => $this->registrationProgramMap($programs),
        ]);
    }

    public function faculty(string $slug)
    {
        $allPrograms = Program::all();
        $programs = $allPrograms
            ->filter(fn (Program $program) => $this->programFacultySlug($program) === $slug)
            ->values();
        $faculties = $this->faculties();
        $faculty = collect($faculties)->firstWhere('slug', $slug);

        abort_if(! $faculty, 404);

        return view('faculty', compact('faculty', 'faculties', 'programs'));
    }

    public function decrementQuota(Request $request)
    {
        $data = $request->validate([
            'program_id' => ['required', 'string'],
        ]);

        $detailUrl = self::PROGRAM_CARD_IDS[$data['program_id']] ?? null;

        abort_if(! $detailUrl, 404);

        $updated = Program::where('detail_url', $detailUrl)
            ->where('quota', '>', 0)
            ->decrement('quota');

        $program = Program::where('detail_url', $detailUrl)->firstOrFail();

        if (! $updated) {
            return response()->json([
                'ok' => false,
                'quota' => 0,
                'message' => 'Kuota program sudah habis.',
            ], 409);
        }

        $program->refresh();

        return response()->json([
            'ok' => true,
            'quota' => $program->quota,
        ]);
    }


    private function faculties($programs = null): array
    {
        $programs ??= Program::all();

        $items = [
            [
                'slug' => 'ekonomi-bisnis',
                'code' => 'FEB',
                'name' => 'Ekonomi Bisnis',
                'subtitle' => 'Bisnis, manajemen, keuangan, pemasaran, risiko, dan tata kelola organisasi.',
                'about' => 'Fakultas Ekonomi Bisnis berfokus pada penguatan kompetensi bisnis dan profesional agar peserta siap membaca peluang, mengelola risiko, dan mengambil keputusan berbasis data.',
                'classes' => ['Kelas Bisnis & Manajemen', 'Kelas Keuangan & Risiko', 'Kelas Marketing & Sales'],
                'icon' => 'finance',
            ],
            [
                'slug' => 'teknik-industri',
                'code' => 'FTI',
                'name' => 'Teknik Industri',
                'subtitle' => 'Sistem industri, manufaktur, optimasi proses, manajemen proyek, dan mutu operasional.',
                'about' => 'Fakultas Teknik Industri menghubungkan kemampuan teknis dengan manajemen operasi, sehingga peserta mampu memperbaiki proses, produktivitas, dan kualitas kerja industri.',
                'classes' => ['Kelas Operasi & Supply Chain', 'Kelas Mutu & Produktivitas', 'Kelas Proyek & Manufaktur'],
                'icon' => 'industry',
            ],
            [
                'slug' => 'teknologi-kreatif',
                'code' => 'FTK',
                'name' => 'Teknologi Kreatif',
                'subtitle' => 'Desain digital, komunikasi visual, teknologi terapan, dan pemasaran kreatif.',
                'about' => 'Fakultas Teknologi Kreatif menyiapkan peserta untuk menguasai keterampilan digital, komunikasi visual, desain, dan teknologi terapan yang relevan untuk kebutuhan industri kreatif.',
                'classes' => ['Kelas Desain & Digital', 'Kelas Marketing Kreatif', 'Kelas Teknologi Terapan'],
                'icon' => 'creative',
            ],
            [
                'slug' => 'bahasa',
                'code' => 'BHS',
                'name' => 'Bahasa',
                'subtitle' => 'Persiapan TOEFL, IELTS, komunikasi profesional, dan bahasa untuk studi lanjut.',
                'about' => 'Fakultas Bahasa berfokus pada penguatan kemampuan bahasa, persiapan tes internasional, dan komunikasi profesional untuk kebutuhan akademik, karier, dan beasiswa.',
                'classes' => ['Kelas TOEFL Preparation', 'Kelas IELTS Coaching', 'Kelas Komunikasi Profesional'],
                'icon' => 'language',
            ],
        ];

        return collect($items)
            ->map(function ($faculty) use ($programs) {
                $facultyPrograms = $programs->filter(fn (Program $program) => $this->programFacultySlug($program) === $faculty['slug']);
                $faculty['program_count'] = $facultyPrograms->count();
                $faculty['categories'] = $facultyPrograms->pluck('category')->unique()->values()->all();

                return $faculty;
            })
            ->all();
    }

    private function programQuotaMap($programs): array
    {
        return $programs
            ->mapWithKeys(fn (Program $program) => [
                $this->programCardId($program->detail_url) => [
                    'quota' => $program->quota,
                    'total_quota' => $program->total_quota,
                ],
            ])
            ->all();
    }

    private function registrationProgramMap($programs): array
    {
        $details = [
            '1' => [
                'category' => 'Ekonomi dan Bisnis - Pelatihan',
                'method' => 'Online',
                'about' => 'Program ini membahas praktik perpajakan dan asuransi untuk membantu peserta memahami kewajiban pajak, membaca risiko bisnis, serta menentukan perlindungan yang sesuai dalam konteks kerja profesional.',
                'syllabusUrl' => '/silabus/perpajakan-asuransi.pdf',
            ],
            '2' => [
                'category' => 'Teknologi Kreatif - Pelatihan',
                'method' => 'Online',
                'about' => 'Peserta akan mempelajari proses desain produk digital dari riset pengguna, penyusunan alur, wireframe, prototype, hingga pengujian agar solusi yang dibuat lebih mudah digunakan.',
                'syllabusUrl' => '/silabus/ui-ux-design-fundamental.pdf',
            ],
            '3' => [
                'category' => 'Teknik & Industri - Sertifikasi',
                'method' => 'Online',
                'about' => 'Program ini dirancang untuk memperkuat kemampuan mengelola proyek mulai dari perencanaan, pembagian tugas, pengendalian risiko, sampai evaluasi hasil kerja.',
                'syllabusUrl' => '/silabus/sertifikasi-manajemen-proyek.pdf',
            ],
            '4' => [
                'category' => 'Teknik & Industri - Sertifikasi',
                'method' => 'Online',
                'about' => 'Pelatihan ini membantu peserta menguasai penggunaan AutoCAD untuk membuat gambar teknis yang rapi, presisi, dan siap digunakan dalam kebutuhan profesional.',
                'syllabusUrl' => '/silabus/autocad-professional.pdf',
            ],
            '5' => [
                'category' => 'Unit Bahasa',
                'method' => 'Online',
                'about' => 'Program persiapan TOEFL ini berfokus pada latihan terarah untuk meningkatkan kemampuan listening, structure, dan reading melalui pembahasan strategi serta simulasi soal.',
                'syllabusUrl' => '/silabus/toefl-preparation-program.pdf',
            ],
            '6' => [
                'category' => 'Unit Bahasa',
                'method' => 'Online',
                'about' => 'Coaching IELTS ini membantu peserta menyiapkan empat kemampuan utama, yaitu listening, reading, writing, dan speaking dengan latihan intensif dan umpan balik.',
                'syllabusUrl' => '/silabus/ielts-intensive-coaching.pdf',
            ],
            '7' => [
                'category' => 'Ekonomi dan Bisnis - Pelatihan',
                'method' => 'Online',
                'about' => 'Program ini membekali peserta dengan kemampuan merancang kampanye digital, mengelola konten, memahami audiens, dan membaca performa pemasaran berbasis data.',
                'syllabusUrl' => '/silabus/digital-marketing-specialist.pdf',
            ],
            'a' => [
                'category' => 'Global Economics & Business - Pelatihan',
                'method' => 'Online',
                'about' => 'International class ini membahas corporate tax, compliance, dan risk management agar peserta memahami pengelolaan pajak serta risiko perusahaan secara lebih strategis.',
                'syllabusUrl' => '/silabus/corporate-tax-risk-management.pdf',
            ],
            'b' => [
                'category' => 'Creative Technology - Pelatihan',
                'method' => 'Online',
                'about' => 'International class ini memperkenalkan proses UI/UX dari design thinking, prototyping, hingga validasi pengalaman pengguna untuk produk digital.',
                'syllabusUrl' => '/silabus/ui-ux-design-fundamental-intl.pdf',
            ],
        ];

        return $programs
            ->mapWithKeys(function (Program $program) use ($details) {
                $id = $this->programCardId($program->detail_url);
                $detail = $details[$id] ?? [];

                return [
                    $id => [
                        'name' => $program->title,
                        'category' => $detail['category'] ?? ucfirst($program->category),
                        'price' => $program->price,
                        'date' => $program->registration_date,
                        'method' => $detail['method'] ?? 'Online',
                        'quota' => $program->quota,
                        'totalQuota' => $program->total_quota,
                        'about' => $detail['about'] ?? '',
                        'syllabusUrl' => $detail['syllabusUrl'] ?? '#',
                    ],
                ];
            })
            ->all();
    }

    private function programCardId(string $detailUrl): string
    {
        return array_search($detailUrl, self::PROGRAM_CARD_IDS, true) ?: preg_replace('/^detail/', '', $detailUrl);
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
