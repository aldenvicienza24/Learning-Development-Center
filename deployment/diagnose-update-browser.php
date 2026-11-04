<?php

declare(strict_types=1);

// Generate a release copy using the existing activation hash before uploading.
const ACTIVATION_HASH = '__ACTIVATION_HASH__';

ini_set('display_errors', '0');
set_time_limit(60);
header('Cache-Control: no-store, max-age=0');
header('Referrer-Policy: no-referrer');
header('X-Frame-Options: DENY');
header("Content-Security-Policy: default-src 'none'; form-action 'self'; frame-ancestors 'none'");

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!doctype html><html lang="id"><meta charset="utf-8"><title>Pemeriksaan update UISI</title><h1>Pemeriksaan update UISI</h1><p>Hanya membaca status migrasi dan struktur tabel. Tidak menjalankan migrasi atau mengubah data.</p><form method="post"><label>Kunci aktivasi sebelumnya <input type="password" name="key" required autocomplete="off"></label><button>Periksa</button></form></html>';
    exit;
}

header('Content-Type: text/plain; charset=UTF-8');
if (!preg_match('/^[a-f0-9]{64}$/', ACTIVATION_HASH) || !hash_equals(ACTIVATION_HASH, hash('sha256', (string) ($_POST['key'] ?? '')))) {
    http_response_code(403);
    exit("Kunci tidak valid.\n");
}

function safeErrorSummary(string $message): string
{
    $parts = [];
    if (preg_match('/SQLSTATE\[([A-Z0-9]{5})\]/', $message, $match)) {
        $parts[] = 'SQLSTATE '.$match[1];
    }
    if (preg_match('/(?:SQLSTATE\[[A-Z0-9]{5}\][^\r\n]*?:\s*|\[)(\d{3,5})(?:\]|\s)/', $message, $match)) {
        $parts[] = 'Kode driver '.$match[1];
    }
    // Only known schema-metadata names may be shown, never arbitrary quoted values.
    foreach (['generation_expression', 'column_name', 'data_type', 'column_type', 'collation_name', 'is_nullable', 'column_default', 'column_comment', 'extra', 'ordinal_position'] as $metadata) {
        if (stripos($message, "Unknown column '".$metadata."'") !== false) {
            $parts[] = 'Metadata tidak tersedia: '.$metadata;
        }
    }
    // Fixed descriptions only: never return raw SQL, connection details, or row values.
    foreach ([
        'duplicate column' => 'Kolom sudah ada',
        'already exists' => 'Tabel atau objek sudah ada',
        'unknown column' => 'Kolom tidak ditemukan',
        "doesn't exist" => 'Tabel tidak ditemukan',
        'foreign key constraint' => 'Masalah foreign key',
        'incorrectly formed' => 'Definisi constraint tidak cocok',
        'incompatible' => 'Tipe kolom tidak cocok',
        'identifier name' => 'Nama indeks/constraint terlalu panjang',
        'specified key was too long' => 'Ukuran indeks terlalu besar',
        'access denied' => 'Akses database ditolak',
        'command denied' => 'Izin perintah database ditolak',
    ] as $needle => $label) {
        if (stripos($message, $needle) !== false) {
            $parts[] = $label;
        }
    }
    return $parts ? implode('; ', $parts) : 'Tidak ada kode database yang dapat ditampilkan dengan aman';
}

$root = dirname(__DIR__).'/laravel';
try {
    echo "DIAGNOSIS UISI v2 — hanya baca\nPHP: ".PHP_VERSION."\n";
    require $root.'/vendor/autoload.php';
    $app = require $root.'/bootstrap/app.php';
    $app->usePublicPath(__DIR__);
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    $db = Illuminate\Support\Facades\DB::connection();
    $schema = $db->getSchemaBuilder();
    echo 'Driver: '.$db->getDriverName()."\n";
    $mysql = in_array($db->getDriverName(), ['mysql', 'mariadb'], true);
    if ($mysql) {
        echo 'Versi server database: '.preg_replace('/[^0-9A-Za-z .+_\-]/', '', (string) $db->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION))."\n";
        echo "\nPEMERIKSAAN METADATA LARAVEL:\n";
        try {
            $schema->getColumns('programs');
            echo "Pembacaan metadata Laravel berhasil.\n";
        } catch (Illuminate\Database\QueryException $exception) {
            echo safeErrorSummary($exception->getMessage())."\n";
            echo "Pemeriksaan dilanjutkan menggunakan metadata dasar.\n";
        }
    }
    $repository = config('database.migrations.table', 'migrations');
    $ran = $schema->hasTable($repository) ? $db->table($repository)->pluck('migration')->all() : [];
    echo "\nMIGRASI BELUM TERCATAT SELESAI:\n";
    $pending = [];
    foreach (glob($root.'/database/migrations/*.php') ?: [] as $file) {
        $name = basename($file, '.php');
        if (!in_array($name, $ran, true)) {
            $pending[] = $name;
            echo $name."\n";
        }
    }
    if (!$pending) {
        echo "Semua migrasi sudah tercatat selesai.\n";
    }
    echo "\nSTRUKTUR TABEL (tanpa isi data):\n";
    foreach (['programs', 'registrations', 'testimonials', 'payment_push_subscriptions', 'jobs'] as $table) {
        echo "\n[$table]\n";
        if (!$schema->hasTable($table)) {
            echo "Belum ada\n";
            continue;
        }
        // Older MySQL/MariaDB can lack generation_expression in information_schema.
        // Read only the three basic metadata fields needed for this report.
        $columns = $mysql
            ? array_map(static fn ($column) => [
                'name' => $column->name,
                'type' => $column->type,
                'nullable' => $column->nullable === 'YES',
            ], $db->select(
                'select COLUMN_NAME as name, COLUMN_TYPE as type, IS_NULLABLE as nullable from information_schema.columns where TABLE_SCHEMA = ? and TABLE_NAME = ? order by ORDINAL_POSITION',
                [$db->getDatabaseName(), $db->getTablePrefix().$table]
            ))
            : $schema->getColumns($table);
        foreach ($columns as $column) {
            echo $column['name'].': '.$column['type'].($column['nullable'] ? ' NULL' : ' NOT NULL')."\n";
        }
        foreach ($schema->getIndexes($table) as $index) {
            echo 'INDEX '.$index['name'].' ('.implode(', ', $index['columns']).")\n";
        }
    }
    echo "\nKODE ERROR TERAKHIR YANG DAPAT DIBACA:\n";
    $paths = [dirname($root).'/logs/error_log', $root.'/storage/logs/laravel.log'];
    $phpLog = ini_get('error_log');
    if (is_string($phpLog) && str_starts_with($phpLog, dirname($root).'/')) {
        $paths[] = $phpLog;
    }
    $found = false;
    foreach (array_unique($paths) as $path) {
        if (!@is_file($path) || !@is_readable($path)) {
            continue;
        }
        $handle = @fopen($path, 'rb');
        if (!$handle) {
            continue;
        }
        try {
            $size = fstat($handle)['size'];
            fseek($handle, max(0, $size - 262144));
            $lines = explode("\n", stream_get_contents($handle));
        } finally {
            fclose($handle);
        }
        foreach (array_reverse($lines) as $line) {
            if (str_contains($line, 'UISI browser update failed')) {
                echo safeErrorSummary($line)."\n";
                $found = true;
                break;
            }
        }
    }
    if (!$found) {
        echo "Log tidak tersedia bagi PHP; gunakan daftar migrasi dan struktur di atas.\n";
    }
    echo "\nSelesai. Kirim hasil ini untuk pemeriksaan. Hapus file pemeriksa setelah masalah selesai.\n";
} catch (Throwable $exception) {
    http_response_code(500);
    echo "\nPemeriksaan terhenti: ".get_class($exception)."\n".safeErrorSummary($exception->getMessage())."\n";
}
