<?php

declare(strict_types=1);

const ACTIVATION_HASH = '__ACTIVATION_HASH__';
const RELEASE_FILES = [];
ini_set('display_errors', '0');
set_time_limit(60);
header('Cache-Control: no-store, max-age=0');
header('Referrer-Policy: no-referrer');
header('X-Frame-Options: DENY');
header("Content-Security-Policy: default-src 'none'; form-action 'self'; frame-ancestors 'none'");

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!doctype html><html lang="id"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Aktifkan analitik UISI</title><h1>Aktifkan perbaikan analitik</h1><p>Jalankan setelah ZIP perbaikan diekstrak. Proses membersihkan konfigurasi lama dan memeriksa perhitungan grafik. Tidak menjalankan migrasi atau mengubah data peserta.</p><form method="post"><label>Kunci aktivasi sebelumnya <input type="password" name="key" required autocomplete="off"></label><button>Aktifkan analitik</button></form></html>';
    exit;
}
header('Content-Type: text/plain; charset=UTF-8');
if (!preg_match('/^[a-f0-9]{64}$/', ACTIVATION_HASH) || !hash_equals(ACTIVATION_HASH, hash('sha256', (string) ($_POST['key'] ?? '')))) {
    http_response_code(403);
    exit("Kunci tidak valid.\n");
}

$root = dirname(__DIR__).'/laravel';
$step = 'Memeriksa file pembaruan';
try {
    echo "Perbaikan analitik V2 (GROUP BY).\n";
    foreach (['app/Services/DashboardAnalyticsService.php', 'app/Services/PhpDashboardAnalytics.php', 'config/analytics.php'] as $relative) {
        $path = $root.'/'.$relative;
        if (!is_file($path)) {
            throw new RuntimeException('File perbaikan belum lengkap. Extract ZIP di /home/biz.partnership.');
        }
        if (isset(RELEASE_FILES[$relative]) && !hash_equals(RELEASE_FILES[$relative], (string) hash_file('sha256', $path))) {
            throw new RuntimeException('File perbaikan belum sesuai versi V2. Extract ulang ZIP V2 dan pilih Overwrite.');
        }
        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($path, true);
        }
    }
    $step = 'Membersihkan konfigurasi lama';
    $cache = $root.'/bootstrap/cache/config.php';
    if (is_file($cache) && !unlink($cache)) {
        throw new RuntimeException('Cache konfigurasi tidak dapat dihapus. Periksa izin bootstrap/cache.');
    }
    if (function_exists('opcache_invalidate')) {
        opcache_invalidate($cache, true);
    }
    require $root.'/vendor/autoload.php';
    $app = require $root.'/bootstrap/app.php';
    $app->usePublicPath(__DIR__);
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    if (Illuminate\Support\Facades\Artisan::call('config:clear') !== 0) {
        throw new RuntimeException('Cache konfigurasi tidak dapat dihapus. Periksa izin bootstrap/cache.');
    }
    $step = 'Memeriksa data dan grafik';
    if (config('analytics.engine', 'php') !== 'php') {
        throw new RuntimeException('Ubah ANALYTICS_ENGINE di .env menjadi php lalu ulangi aktivasi.');
    }
    $end = Carbon\CarbonImmutable::today(config('app.timezone'));
    $result = $app->make(App\Services\DashboardAnalyticsService::class)->calculate([
        'start_date' => $end->startOfMonth()->subMonths(5)->toDateString(),
        'end_date' => $end->toDateString(), 'interval' => 'month',
    ]);
    if (!isset($result['summary'], $result['charts']['revenue_trend'], $result['charts']['popular_programs'])) {
        throw new RuntimeException('Hasil analitik belum lengkap.');
    }
    echo "BERHASIL. Analitik PHP dan data grafik berhasil diperiksa.\nBuka Dashboard Analitik lalu klik Muat ulang atau tekan Ctrl + F5.\n";
    echo unlink(__FILE__) ? "File aktivasi terhapus otomatis.\n" : 'Hapus manual '.basename(__FILE__)." dari public_html.\n";
} catch (Throwable $exception) {
    http_response_code(500);
    error_log('UISI analytics activation failed at '.$step.': '.$exception->getMessage());
    echo "BELUM SELESAI pada tahap: {$step}.\n";
    if (in_array($exception->getMessage(), [
        'File perbaikan belum lengkap. Extract ZIP di /home/biz.partnership.',
        'File perbaikan belum sesuai versi V2. Extract ulang ZIP V2 dan pilih Overwrite.',
        'Cache konfigurasi tidak dapat dihapus. Periksa izin bootstrap/cache.',
        'Ubah ANALYTICS_ENGINE di .env menjadi php lalu ulangi aktivasi.',
        'Hasil analitik belum lengkap.',
    ], true)) {
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
            $sql = $exception->getSql();
            foreach (['analytics_registrations' => 'Pengelompokan pendaftaran', 'analytics_receipts' => 'Pengelompokan pemasukan'] as $marker => $label) {
                if (str_contains($sql, $marker)) {
                    echo 'Kueri: '.$label."\n";
                    break;
                }
            }
            // A fixed metadata allowlist; never display raw queries or database names.
            foreach (['program_id', 'created_at', 'registration_date', 'payment_status', 'participant_status', 'status', 'payment_received_at', 'received_date', 'payment_amount', 'legacy_date'] as $column) {
                if (preg_match('/[.`\x27]'.preg_quote($column, '/').'[`\x27]/', (string) ($info[2] ?? ''))) {
                    echo 'Kolom terkait: '.$column."\n";
                }
            }
        }
    }
    echo "Kirim hasil pemeriksaan ini; jangan kirim isi .env.\n";
}
