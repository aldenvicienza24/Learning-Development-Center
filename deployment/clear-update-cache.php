<?php

declare(strict_types=1);

header('Content-Type: text/plain; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$expectedKey = 'uisi-update-20260905-f13d7c86a24e49b1';

if (! hash_equals($expectedKey, (string) ($_GET['key'] ?? ''))) {
    http_response_code(403);
    exit("Kunci tidak valid.\n");
}

$laravelRoot = dirname(__DIR__).'/laravel';
$cacheDirectories = [
    $laravelRoot.'/bootstrap/cache',
    $laravelRoot.'/storage/framework/views',
    $laravelRoot.'/storage/framework/cache/data',
];

function clearCacheDirectory(string $directory): int
{
    if (! is_dir($directory)) {
        return 0;
    }

    $deleted = 0;
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($iterator as $item) {
        if ($item->getFilename() === '.gitignore') {
            continue;
        }

        if ($item->isDir() && ! $item->isLink()) {
            @rmdir($item->getPathname());
            continue;
        }

        if (@unlink($item->getPathname())) {
            $deleted++;
        }
    }

    return $deleted;
}

$deleted = 0;
foreach ($cacheDirectories as $directory) {
    $deleted += clearCacheDirectory($directory);
}

if (function_exists('opcache_reset')) {
    @opcache_reset();
}

echo "Update UISI berhasil diaktifkan.\n";
echo "File cache dihapus: {$deleted}\n";
echo "Database, .env, dan storage tidak disentuh.\n";

if (@unlink(__FILE__)) {
    echo "File pembersih sudah terhapus otomatis.\n";
} else {
    echo "PENTING: hapus manual public_html/clear-update-cache.php.\n";
}
