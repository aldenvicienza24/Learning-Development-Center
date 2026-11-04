<?php

declare(strict_types=1);

set_time_limit(120);
header('Content-Type: text/plain; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$expectedKey = 'uisi-seat-8f47c2a91d6e30b5';

if (! hash_equals($expectedKey, (string) ($_GET['key'] ?? ''))) {
    http_response_code(404);
    exit("Not Found\n");
}

$laravelRoot = dirname(__DIR__).'/laravel';
$autoloadPath = $laravelRoot.'/vendor/autoload.php';
$bootstrapPath = $laravelRoot.'/bootstrap/app.php';

if (! is_file($autoloadPath) || ! is_file($bootstrapPath)) {
    http_response_code(500);
    exit("[GAGAL] Aplikasi Laravel tidak ditemukan di {$laravelRoot}.\n");
}

require $autoloadPath;

$app = require $bootstrapPath;
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "UISI - Update reservasi kursi\n";
    echo 'PHP '.PHP_VERSION."\n\n";

    $migrationExitCode = Illuminate\Support\Facades\Artisan::call('migrate', [
        '--force' => true,
        '--no-interaction' => true,
    ]);
    echo Illuminate\Support\Facades\Artisan::output();

    if ($migrationExitCode !== 0) {
        throw new RuntimeException("Migration gagal dengan kode {$migrationExitCode}.");
    }

    echo "[OK] Migration database selesai.\n\n";

    $cacheExitCode = Illuminate\Support\Facades\Artisan::call('optimize:clear', [
        '--no-interaction' => true,
    ]);
    echo Illuminate\Support\Facades\Artisan::output();

    if ($cacheExitCode !== 0) {
        throw new RuntimeException("Pembersihan cache gagal dengan kode {$cacheExitCode}.");
    }

    echo "[OK] Cache aplikasi dibersihkan.\n";
    echo "[OK] Update reservasi kursi siap digunakan.\n";

    if (@unlink(__FILE__)) {
        echo "[OK] File updater sudah terhapus otomatis.\n";
    } else {
        echo "[PERINGATAN] Hapus manual public_html/jalankan-update-kursi.php.\n";
    }
} catch (Throwable $exception) {
    report($exception);
    http_response_code(500);
    echo "\n[GAGAL] {$exception->getMessage()}\n";
    echo "File updater belum dihapus agar dapat dicoba kembali.\n";
}
