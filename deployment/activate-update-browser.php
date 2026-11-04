<?php

declare(strict_types=1);

// Build a release copy with a random activation-key hash, never upload this template.
const ACTIVATION_HASH = '__ACTIVATION_HASH__';
const RELEASE = 'uisi-20260918-payment-push';

ini_set('display_errors', '0');
set_time_limit(180);
header('Cache-Control: no-store, max-age=0');
header('Referrer-Policy: no-referrer');
header('X-Frame-Options: DENY');
header("Content-Security-Policy: default-src 'none'; style-src 'unsafe-inline'; form-action 'self'; frame-ancestors 'none'");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!doctype html><html lang="id"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Aktivasi pembaruan UISI</title>
    <body style="font:16px system-ui;background:#f5f6fa;padding:24px"><main style="max-width:520px;margin:40px auto;background:white;padding:28px;border-radius:18px">
    <h1>Aktivasi pembaruan UISI</h1><p>Jalankan setelah ZIP pembaruan selesai diekstrak. Proses ini mempertahankan koneksi database hosting, menjalankan migrasi, serta menyiapkan notifikasi HP. Konfigurasi .env dicadangkan otomatis. SQLite juga dicadangkan otomatis; backup MySQL/MariaDB harus dibuat lewat Virtualmin terlebih dahulu.</p>
    <p>Website masuk mode pemeliharaan selama proses. Email tetap membutuhkan SMTP valid dan pengingat membutuhkan worker atau cron.</p>
    <form method="post"><label>Kunci aktivasi<br><input type="password" name="key" required autocomplete="off" style="box-sizing:border-box;width:100%;padding:12px;margin:10px 0"></label>
    <label style="display:block;margin:14px 0"><input type="checkbox" name="ready" value="yes" required> ZIP sudah diekstrak dan backup hosting sudah tersedia.</label>
    <label style="display:block;margin:14px 0"><input type="checkbox" name="database_backup" value="yes" required> Backup terbaru database produksi sudah tersedia, termasuk database MySQL/MariaDB jika digunakan.</label>
    <button style="background:#b91c1c;color:white;padding:12px 20px;border:0;border-radius:10px">Aktifkan pembaruan</button></form></main></body></html>';
    exit;
}

header('Content-Type: text/plain; charset=UTF-8');
if (!hash_equals(ACTIVATION_HASH, hash('sha256', (string) ($_POST['key'] ?? ''))) || ($_POST['ready'] ?? '') !== 'yes' || ($_POST['database_backup'] ?? '') !== 'yes') {
    http_response_code(403);
    exit("Kunci aktivasi salah atau konfirmasi belum dipilih.\n");
}

$root = dirname(__DIR__).'/laravel';
$step = 'Pemeriksaan awal';
$lock = null;
try {
    echo 'PHP: '.PHP_VERSION."\n";
    foreach ([
        'Folder Laravel' => is_dir($root),
        'Library aplikasi' => is_file($root.'/vendor/autoload.php'),
        'Kode pengingat terbaru' => is_file($root.'/app/Jobs/SendPaymentPushReminder.php'),
        'Bootstrap aplikasi' => is_file($root.'/bootstrap/app.php'),
        'Folder storage/framework dapat ditulis' => is_writable($root.'/storage/framework'),
        'Folder bootstrap/cache dapat ditulis' => is_writable($root.'/bootstrap/cache'),
        'Konfigurasi .env dapat dibaca' => is_readable($root.'/.env'),
        'Konfigurasi .env dapat ditulis' => is_writable($root.'/.env'),
    ] as $label => $valid) {
        echo ($valid ? '[OK] ' : '[PERIKSA] ').$label."\n";
    }
    if (PHP_VERSION_ID < 80200) {
        throw new RuntimeException('Gunakan PHP 8.2 atau lebih baru pada pengaturan PHP domain.');
    }
    if (!is_file($root.'/vendor/autoload.php') || !is_file($root.'/app/Jobs/SendPaymentPushReminder.php')) {
        throw new RuntimeException('Paket belum lengkap. Ekstrak ZIP update di /home/biz.partnership, bukan di dalam public_html.');
    }
    $marker = $root.'/storage/app/private/'.RELEASE.'.done';
    if (is_file($marker)) {
        exit("Pembaruan ini sudah diaktifkan. Hapus file aktivasi dari public_html.\n");
    }
    $step = 'Mengunci proses aktivasi';
    $lock = fopen($root.'/storage/framework/browser-update.lock', 'c');
    if (!$lock || !flock($lock, LOCK_EX | LOCK_NB)) {
        throw new RuntimeException('Aktivasi lain masih berjalan.');
    }
    $step = 'Membersihkan metadata bootstrap';
    // Remove only generated bootstrap metadata, not application or user files.
    foreach (['config.php', 'packages.php', 'services.php'] as $cache) {
        $path = $root.'/bootstrap/cache/'.$cache;
        if (is_file($path) && !unlink($path)) {
            throw new RuntimeException('Cache tidak dapat dibersihkan.');
        }
    }
    $step = 'Memuat library Composer';
    require $root.'/vendor/autoload.php';
    $step = 'Memulai Laravel';
    $app = require $root.'/bootstrap/app.php';
    $app->usePublicPath(__DIR__);
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    $artisan = function (string $name, array $arguments = []): void {
        $code = Illuminate\Support\Facades\Artisan::call($name, $arguments + ['--no-interaction' => true]);
        if ($code !== 0) {
            throw new RuntimeException('Perintah gagal: '.$name);
        }
        echo '[OK] '.$name."\n";
    };
    $step = 'Memeriksa konfigurasi dan koneksi database';
    $envPath = $root.'/.env';
    if (!is_readable($envPath) || !is_writable($envPath)) {
        throw new RuntimeException('.env tidak dapat ditulis.');
    }
    $connection = Illuminate\Support\Facades\DB::connection();
    $driver = $connection->getDriverName();
    if (!in_array($driver, ['sqlite', 'mysql', 'mariadb'], true)) {
        throw new RuntimeException('Aktivator mendukung SQLite dan MySQL/MariaDB.');
    }
    $pdo = $connection->getPdo();
    echo '[OK] Koneksi database '.($driver === 'sqlite' ? 'SQLite' : 'MySQL/MariaDB').". Konfigurasi database dipertahankan.\n";
    $step = 'Backup database dan konfigurasi';
    $backup = $root.'/storage/app/private/update-backups/'.date('Ymd-His').'-'.bin2hex(random_bytes(4));
    if (!mkdir($backup, 0700, true) || !copy($envPath, $backup.'/.env')) {
        throw new RuntimeException('Backup konfigurasi gagal.');
    }
    chmod($backup.'/.env', 0600);
    $artisan('down');
    if ($driver === 'sqlite') {
        $pdo->exec('VACUUM INTO '.$pdo->quote($backup.'/database.sqlite'));
        chmod($backup.'/database.sqlite', 0600);
        echo "[OK] Backup SQLite disimpan di storage/app/private/update-backups.\n";
    } else {
        echo "[INFO] Menggunakan backup MySQL/MariaDB yang telah Anda konfirmasi. Aktivator tidak membuat dump MySQL/MariaDB.\n";
    }
    echo "[OK] Backup .env disimpan di storage/app/private/update-backups.\n";

    $step = 'Konfigurasi produksi';
    $env = file_get_contents($envPath);
    foreach ([
        'APP_ENV' => 'production', 'APP_DEBUG' => 'false',
        'APP_URL' => 'https://biz.partnership.uisi.ac.id', 'APP_TIMEZONE' => 'Asia/Jakarta',
        'QUEUE_CONNECTION' => 'database', 'WEBPUSH_SUBJECT' => 'https://biz.partnership.uisi.ac.id',
    ] as $key => $value) {
        $pattern = '/^'.preg_quote($key, '/').'=.*$/m';
        $env = preg_match($pattern, $env) ? preg_replace($pattern, $key.'='.$value, $env) : rtrim($env).PHP_EOL.$key.'='.$value.PHP_EOL;
    }
    if (file_put_contents($envPath, $env, LOCK_EX) === false) {
        throw new RuntimeException('Penyimpanan .env gagal.');
    }
    $step = 'Migrasi database';
    if (function_exists('opcache_invalidate')) {
        foreach (glob($root.'/database/migrations/*.php') ?: [] as $migrationFile) {
            opcache_invalidate($migrationFile, true);
        }
    }
    $app['events']->listen(Illuminate\Database\Events\MigrationStarted::class, function ($event) use (&$step): void {
        $file = (new ReflectionClass($event->migration))->getFileName();
        $step = 'Migrasi '.basename($file ?: 'database', '.php');
    });
    $artisan('migrate', ['--force' => true]);
    $step = 'Kunci notifikasi HP';
    $keyValues = Dotenv\Dotenv::parse(file_get_contents($envPath));
    if (empty($keyValues['WEBPUSH_PUBLIC_KEY']) && empty($keyValues['WEBPUSH_PRIVATE_KEY'])) {
        $artisan('webpush:keys');
    } elseif (empty($keyValues['WEBPUSH_PUBLIC_KEY']) || empty($keyValues['WEBPUSH_PRIVATE_KEY'])) {
        throw new RuntimeException('Pasangan kunci Web Push tidak lengkap.');
    } else {
        echo "[OK] Kunci notifikasi HP lama dipertahankan.\n";
    }
    $step = 'Membersihkan cache';
    $artisan('optimize:clear');
    $artisan('package:discover');
    $artisan('view:cache');
    $artisan('queue:restart');
    $artisan('up');
    if (file_put_contents($marker, date(DATE_ATOM), LOCK_EX) === false) {
        throw new RuntimeException('Penanda penyelesaian gagal disimpan.');
    }
    if (function_exists('opcache_reset')) {
        opcache_reset();
    }
    echo "\nBERHASIL. Buka website lalu refresh.\n";
    echo "Pengingat saat halaman ditutup masih membutuhkan worker/cron server. SMTP valid diperlukan untuk email.\n";
    echo unlink(__FILE__) ? "File aktivasi telah terhapus otomatis.\n" : "Hapus manual file aktivasi dari public_html.\n";
} catch (Throwable $exception) {
    error_log('UISI browser update failed at '.$step.': '.$exception->getMessage());
    http_response_code(500);
    echo "\nBELUM SELESAI pada tahap: {$step}.\n";
    // Only our fixed messages are safe to display. Database/bootstrap errors may contain secrets.
    $safeMessages = [
        'Gunakan PHP 8.2 atau lebih baru pada pengaturan PHP domain.',
        'Paket belum lengkap. Ekstrak ZIP update di /home/biz.partnership, bukan di dalam public_html.',
        'Aktivasi lain masih berjalan.', 'Cache tidak dapat dibersihkan.',
        '.env tidak dapat ditulis.', 'Aktivator mendukung SQLite dan MySQL/MariaDB.',
        'Backup konfigurasi gagal.', 'Penyimpanan .env gagal.',
        'Pasangan kunci Web Push tidak lengkap.', 'Penanda penyelesaian gagal disimpan.',
    ];
    if (in_array($exception->getMessage(), $safeMessages, true)) {
        echo $exception->getMessage()."\n";
    } else {
        echo 'Jenis kesalahan: '.get_class($exception)."\n";
        if ($exception instanceof Illuminate\Database\QueryException) {
            $info = $exception->errorInfo ?? [];
            if (preg_match('/^[A-Z0-9]{5}$/', (string) ($info[0] ?? ''))) {
                echo 'SQLSTATE: '.$info[0]."\n";
            }
            if (ctype_digit((string) ($info[1] ?? ''))) {
                echo 'Kode driver: '.$info[1]."\n";
            }
        }
        if (str_contains($exception->getMessage(), 'Permission denied')) {
            echo "Izin akses ditolak. Periksa owner dan permission folder Laravel, storage, dan bootstrap/cache.\n";
        }
        if (str_contains($exception->getMessage(), 'could not find driver')) {
            echo "Driver database PHP belum aktif. Untuk SQLite aktifkan pdo_sqlite.\n";
        }
        if (preg_match('/Class ["\']([A-Za-z0-9_\\\\]+)["\'] not found/', $exception->getMessage(), $match)) {
            echo 'Class tidak ditemukan: '.$match[1].". Pastikan folder vendor dari ZIP ikut diekstrak.\n";
        }
    }
    echo "Periksa log PHP/server atau laravel/storage/logs/laravel.log. Jangan bagikan isi .env.\n";
    echo "Jika website masih maintenance, perbaiki penyebab lalu buka kembali aktivator ini untuk mencoba lagi.\n";
} finally {
    if (is_resource($lock)) {
        flock($lock, LOCK_UN);
        fclose($lock);
    }
}
