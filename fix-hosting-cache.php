<?php

declare(strict_types=1);

header('Content-Type: text/plain; charset=UTF-8');

$expectedKey = 'uisi-cache-20260830';

if (! hash_equals($expectedKey, (string) ($_GET['key'] ?? ''))) {
    http_response_code(403);
    exit("Kunci tidak valid.\n");
}

$laravelRoot = dirname(__DIR__).'/laravel';
$environmentPath = $laravelRoot.'/.env';

if (! is_file($environmentPath) || ! is_readable($environmentPath) || ! is_writable($environmentPath)) {
    http_response_code(500);
    exit("File .env tidak ditemukan atau tidak dapat ditulis.\n");
}

$environment = file_get_contents($environmentPath);
if ($environment === false) {
    http_response_code(500);
    exit("Gagal membaca file .env.\n");
}

function setEnvironmentValue(string $contents, string $key, string $value): string
{
    $pattern = '/^'.preg_quote($key, '/').'=.*$/m';
    $replacement = $key.'='.$value;

    if (preg_match($pattern, $contents) === 1) {
        return (string) preg_replace($pattern, $replacement, $contents);
    }

    return rtrim($contents).PHP_EOL.$replacement.PHP_EOL;
}

$environment = setEnvironmentValue($environment, 'CACHE_STORE', 'file');
$environment = setEnvironmentValue($environment, 'SESSION_DRIVER', 'file');

if (file_put_contents($environmentPath, $environment, LOCK_EX) === false) {
    http_response_code(500);
    exit("Gagal menyimpan perubahan .env.\n");
}

@chmod($environmentPath, 0600);

$cachedConfig = $laravelRoot.'/bootstrap/cache/config.php';
if (is_file($cachedConfig)) {
    @unlink($cachedConfig);
}

echo "UISI Laravel cache repair\n\n";
echo "[OK] CACHE_STORE=file\n";
echo "[OK] SESSION_DRIVER=file\n";
echo "[OK] Cached config dibersihkan\n";

if (@unlink(__FILE__)) {
    echo "[OK] File perbaikan sudah terhapus otomatis.\n";
} else {
    echo "HAPUS MANUAL public_html/fix-hosting-cache.php.\n";
}
