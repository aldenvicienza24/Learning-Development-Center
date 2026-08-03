<?php

$database = __DIR__.'/../database/database.sqlite';

if (! file_exists($database)) {
    fwrite(STDERR, "Database not found: {$database}\n");
    exit(1);
}

$pdo = new PDO('sqlite:'.$database);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function columnExists(PDO $pdo, string $table, string $column): bool
{
    $columns = $pdo->query("PRAGMA table_info({$table})")->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $item) {
        if ($item['name'] === $column) {
            return true;
        }
    }

    return false;
}

function addColumn(PDO $pdo, string $table, string $column, string $definition): void
{
    if (! columnExists($pdo, $table, $column)) {
        $pdo->exec("ALTER TABLE {$table} ADD COLUMN {$column} {$definition}");
    }
}

addColumn($pdo, 'programs', 'faculty', "VARCHAR NOT NULL DEFAULT 'teknologi-kreatif'");
addColumn($pdo, 'programs', 'thumbnail', 'VARCHAR');
addColumn($pdo, 'programs', 'description', 'TEXT');
addColumn($pdo, 'programs', 'syllabus', 'TEXT');
addColumn($pdo, 'programs', 'publish_date', 'DATE');
addColumn($pdo, 'programs', 'registration_open_date', 'DATE');
addColumn($pdo, 'programs', 'event_date', 'DATE');
addColumn($pdo, 'programs', 'status', "VARCHAR NOT NULL DEFAULT 'coming_soon'");
addColumn($pdo, 'programs', 'is_registration_closed', 'TINYINT(1) NOT NULL DEFAULT 0');

$programs = [
    'detail1' => [
        'faculty' => 'ekonomi-bisnis',
        'image_url' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=800&h=450&fit=crop',
        'registration_date' => '12 Feb - 12 Mar',
        'registration_open_date' => '2026-02-12',
        'event_date' => '2026-03-12',
        'description' => 'Program ini membahas praktik perpajakan dan asuransi agar peserta memahami kewajiban pajak, pengelolaan risiko, dan perlindungan bisnis secara lebih terarah.',
        'syllabus' => '/silabus/perpajakan-asuransi.pdf',
    ],
    'detail2' => [
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&h=450&fit=crop',
        'registration_date' => '13 Feb - 29 Mar',
        'registration_open_date' => '2026-02-13',
        'event_date' => '2026-03-29',
        'description' => 'Peserta mempelajari dasar riset pengguna, wireframe, prototype, dan pengujian agar mampu merancang pengalaman produk digital yang lebih mudah digunakan.',
        'syllabus' => '/silabus/ui-ux-design-fundamental.pdf',
    ],
    'detail6' => [
        'faculty' => 'ekonomi-bisnis',
        'image_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=450&fit=crop',
        'registration_date' => '18 Mar - 20 Apr',
        'registration_open_date' => '2026-03-18',
        'event_date' => '2026-04-20',
        'description' => 'Program ini membekali peserta dengan kemampuan merancang kampanye digital, mengelola konten, memahami audiens, dan membaca performa pemasaran berbasis data.',
        'syllabus' => '/silabus/digital-marketing-specialist.pdf',
    ],
    'detail3' => [
        'faculty' => 'teknik-industri',
        'image_url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=450&fit=crop',
        'registration_date' => '10 Mar - 25 Apr',
        'registration_open_date' => '2026-03-10',
        'event_date' => '2026-04-25',
        'description' => 'Program ini memperkuat kemampuan mengelola proyek mulai dari perencanaan, pembagian tugas, pengendalian risiko, sampai evaluasi hasil kerja.',
        'syllabus' => '/silabus/sertifikasi-manajemen-proyek.pdf',
    ],
    'detail4' => [
        'faculty' => 'teknik-industri',
        'image_url' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=800&h=450&fit=crop',
        'registration_date' => '15 Mar - 10 Apr',
        'registration_open_date' => '2026-03-15',
        'event_date' => '2026-04-10',
        'description' => 'Pelatihan ini membantu peserta menguasai AutoCAD untuk membuat gambar teknis yang rapi, presisi, dan siap digunakan dalam kebutuhan profesional.',
        'syllabus' => '/silabus/autocad-professional.pdf',
    ],
    'detail5' => [
        'faculty' => 'bahasa',
        'image_url' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&h=450&fit=crop',
        'registration_date' => '20 Feb - 30 Mar',
        'registration_open_date' => '2026-02-20',
        'event_date' => '2026-03-30',
        'description' => 'Program persiapan TOEFL ini berfokus pada latihan listening, structure, dan reading melalui strategi pengerjaan serta simulasi soal.',
        'syllabus' => '/silabus/toefl-preparation-program.pdf',
    ],
    'detail7' => [
        'faculty' => 'bahasa',
        'image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=450&fit=crop',
        'registration_date' => '28 Feb - 15 Mar',
        'registration_open_date' => '2026-02-28',
        'event_date' => '2026-03-15',
        'description' => 'Coaching IELTS ini membantu peserta menyiapkan kemampuan listening, reading, writing, dan speaking dengan latihan intensif serta umpan balik.',
        'syllabus' => '/silabus/ielts-intensive-coaching.pdf',
    ],
];

$statement = $pdo->prepare(
    'UPDATE programs
     SET faculty = :faculty,
         image_url = :image_url,
         thumbnail = :image_url,
         registration_date = :registration_date,
         registration_open_date = :registration_open_date,
         event_date = :event_date,
         publish_date = :publish_date,
         description = :description,
         syllabus = :syllabus,
         status = CASE WHEN COALESCE(quota, 0) > 0 THEN "open_registration" ELSE "closed" END,
         is_registration_closed = CASE WHEN COALESCE(quota, 0) > 0 THEN 0 ELSE 1 END,
         updated_at = :updated_at
     WHERE detail_url = :detail_url'
);

$pdo->beginTransaction();

try {
    foreach ($programs as $detailUrl => $program) {
        $publishDate = date('Y-m-d', strtotime($program['registration_open_date'].' -14 days'));
        $statement->execute($program + [
            'detail_url' => $detailUrl,
            'publish_date' => $publishDate,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    $pdo->commit();
    echo "Program content synced for CMS and dashboard.\n";
} catch (Throwable $exception) {
    $pdo->rollBack();
    fwrite(STDERR, $exception->getMessage()."\n");
    exit(1);
}
