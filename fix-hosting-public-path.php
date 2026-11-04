<?php

declare(strict_types=1);

header('Content-Type: text/plain; charset=UTF-8');

$expectedKey = 'uisi-public-20260830';

if (! hash_equals($expectedKey, (string) ($_GET['key'] ?? ''))) {
    http_response_code(403);
    exit("Kunci tidak valid.\n");
}

$indexPath = __DIR__.'/index.php';

if (! is_file($indexPath) || ! is_readable($indexPath) || ! is_writable($indexPath)) {
    http_response_code(500);
    exit("public_html/index.php tidak ditemukan atau tidak dapat ditulis.\n");
}

$index = file_get_contents($indexPath);
if ($index === false) {
    http_response_code(500);
    exit("Gagal membaca public_html/index.php.\n");
}

if (! str_contains($index, '$app->usePublicPath(__DIR__);')) {
    $needle = '$app->handleRequest(Request::capture());';
    $replacement = '$app->usePublicPath(__DIR__);'.PHP_EOL.PHP_EOL.$needle;

    if (! str_contains($index, $needle)) {
        http_response_code(500);
        exit("Format index.php tidak dikenali.\n");
    }

    $index = str_replace($needle, $replacement, $index);

    if (file_put_contents($indexPath, $index, LOCK_EX) === false) {
        http_response_code(500);
        exit("Gagal memperbarui public_html/index.php.\n");
    }

    @chmod($indexPath, 0644);
}

echo "UISI Laravel public path repair\n\n";
echo "[OK] Laravel public path diarahkan ke public_html\n";
echo "[OK] Vite akan membaca public_html/build/manifest.json\n";

if (@unlink(__FILE__)) {
    echo "[OK] File perbaikan sudah terhapus otomatis.\n";
} else {
    echo "HAPUS MANUAL public_html/fix-hosting-public-path.php.\n";
}
