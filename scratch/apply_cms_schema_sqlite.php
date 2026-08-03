<?php

$database = __DIR__.'/../database/database.sqlite';

if (! file_exists($database)) {
    fwrite(STDERR, "Database not found: {$database}\n");
    exit(1);
}

$pdo = new PDO('sqlite:'.$database);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function tableExists(PDO $pdo, string $table): bool
{
    $statement = $pdo->prepare("SELECT name FROM sqlite_master WHERE type = 'table' AND name = :table");
    $statement->execute(['table' => $table]);

    return (bool) $statement->fetchColumn();
}

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

function slugify(string $value): string
{
    $value = strtolower(trim($value));
    $value = preg_replace('/[^a-z0-9]+/', '-', $value);
    $value = trim($value, '-');

    return $value ?: bin2hex(random_bytes(4));
}

$pdo->beginTransaction();

try {
    addColumn($pdo, 'programs', 'slug', 'VARCHAR');
    addColumn($pdo, 'programs', 'faculty', "VARCHAR NOT NULL DEFAULT 'teknologi-kreatif'");
    addColumn($pdo, 'programs', 'description', 'TEXT');
    addColumn($pdo, 'programs', 'syllabus', 'TEXT');
    addColumn($pdo, 'programs', 'thumbnail', 'VARCHAR');
    addColumn($pdo, 'programs', 'publish_date', 'DATE');
    addColumn($pdo, 'programs', 'registration_open_date', 'DATE');
    addColumn($pdo, 'programs', 'event_date', 'DATE');
    addColumn($pdo, 'programs', 'status', "VARCHAR NOT NULL DEFAULT 'coming_soon'");
    addColumn($pdo, 'programs', 'is_registration_closed', 'TINYINT(1) NOT NULL DEFAULT 0');
    addColumn($pdo, 'users', 'is_admin', 'TINYINT(1) NOT NULL DEFAULT 0');
    $pdo->exec('UPDATE users SET is_admin = 1');

    $programs = $pdo->query('SELECT * FROM programs ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
    $usedSlugs = [];

    foreach ($programs as $program) {
        $slug = $program['slug'] ?: slugify($program['title']);
        $baseSlug = $slug;
        $counter = 2;

        while (in_array($slug, $usedSlugs, true)) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        $usedSlugs[] = $slug;

        $statement = $pdo->prepare(
            'UPDATE programs
             SET slug = :slug,
                 thumbnail = COALESCE(NULLIF(thumbnail, ""), image_url),
                 description = COALESCE(NULLIF(description, ""), :description),
                 syllabus = COALESCE(NULLIF(syllabus, ""), :syllabus)
             WHERE id = :id'
        );

        $statement->execute([
            'id' => $program['id'],
            'slug' => $slug,
            'description' => 'Program '.$program['title'].' dirancang untuk membantu peserta meningkatkan kompetensi melalui materi terarah dan pembelajaran praktis.',
            'syllabus' => 'Materi utama akan disesuaikan dengan kebutuhan program dan dapat diperbarui oleh admin melalui CMS.',
        ]);
    }

    $pdo->exec('CREATE UNIQUE INDEX IF NOT EXISTS programs_slug_unique ON programs (slug)');

    if (! tableExists($pdo, 'registrations')) {
        $pdo->exec(
            'CREATE TABLE registrations (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                program_id INTEGER NOT NULL,
                full_name VARCHAR NOT NULL,
                email VARCHAR NOT NULL,
                phone VARCHAR NOT NULL,
                institution VARCHAR NOT NULL,
                status VARCHAR NOT NULL DEFAULT "baru",
                created_at DATETIME,
                updated_at DATETIME,
                FOREIGN KEY(program_id) REFERENCES programs(id) ON DELETE CASCADE
            )'
        );
        $pdo->exec('CREATE INDEX registrations_program_id_status_index ON registrations (program_id, status)');
        $pdo->exec('CREATE INDEX registrations_created_at_index ON registrations (created_at)');
    }

    addColumn($pdo, 'registrations', 'payment_proof', 'VARCHAR');
    addColumn($pdo, 'registrations', 'participant_status', "VARCHAR NOT NULL DEFAULT 'menunggu_verifikasi'");
    addColumn($pdo, 'registrations', 'payment_status', "VARCHAR NOT NULL DEFAULT 'menunggu_verifikasi'");
    $pdo->exec("UPDATE registrations SET participant_status = COALESCE(NULLIF(participant_status, ''), COALESCE(status, 'menunggu_verifikasi'))");

    if (! tableExists($pdo, 'website_settings')) {
        $pdo->exec(
            'CREATE TABLE website_settings (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                key VARCHAR NOT NULL,
                value TEXT,
                created_at DATETIME,
                updated_at DATETIME
            )'
        );
        $pdo->exec('CREATE UNIQUE INDEX website_settings_key_unique ON website_settings (key)');
    }

    $defaults = [
        'hero_title' => 'Tingkatkan Kompetensi Bersama UISI',
        'hero_description' => 'Temukan program pelatihan, sertifikasi, dan pengembangan profesional yang sesuai dengan kebutuhan karier dan institusi Anda.',
        'hero_banner' => 'images/hero-bg.jpg',
        'logo' => 'images/LogoUISI.png',
        'email' => 'info@uisi.ac.id',
        'whatsapp' => '+62 858-0069-5077',
        'address' => 'Jalan Veteran, Kompleks PT Semen Indonesia, Sidomoro, Kecamatan Kebomas, Kabupaten Gresik, Jawa Timur, Indonesia',
        'instagram' => '#',
        'facebook' => '#',
        'youtube' => '#',
        'linkedin' => '#',
    ];

    $settingStatement = $pdo->prepare(
        'INSERT OR IGNORE INTO website_settings (key, value, created_at, updated_at)
         VALUES (:key, :value, datetime("now"), datetime("now"))'
    );

    foreach ($defaults as $key => $value) {
        $settingStatement->execute(['key' => $key, 'value' => $value]);
    }

    if (tableExists($pdo, 'migrations')) {
        $batch = (int) $pdo->query('SELECT COALESCE(MAX(batch), 0) + 1 FROM migrations')->fetchColumn();
        $migrationExists = $pdo->prepare('SELECT COUNT(*) FROM migrations WHERE migration = :migration');
        $migrationStatement = $pdo->prepare('INSERT INTO migrations (migration, batch) VALUES (:migration, :batch)');

        foreach ([
            '2026_06_24_000001_extend_programs_for_cms',
            '2026_06_24_000002_create_registrations_table',
            '2026_06_24_000003_create_website_settings_table',
            '2026_06_24_000004_add_participant_fields_to_registrations_table',
            '2026_06_24_000005_add_is_admin_to_users_table',
        ] as $migration) {
            $migrationExists->execute(['migration' => $migration]);

            if (! $migrationExists->fetchColumn()) {
                $migrationStatement->execute(['migration' => $migration, 'batch' => $batch]);
            }
        }
    }

    $pdo->commit();
    echo "CMS schema applied successfully.\n";
} catch (Throwable $exception) {
    $pdo->rollBack();
    fwrite(STDERR, $exception->getMessage()."\n");
    exit(1);
}
