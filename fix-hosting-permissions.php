<?php

declare(strict_types=1);

set_time_limit(120);
header('Content-Type: text/plain; charset=UTF-8');

$expectedKey = 'uisi-fix-20260830';

if (! hash_equals($expectedKey, (string) ($_GET['key'] ?? ''))) {
    http_response_code(403);
    exit("Kunci tidak valid.\n");
}

$publicRoot = __DIR__;
$laravelRoot = dirname(__DIR__).'/laravel';

function fixTree(string $path, int $directoryMode, int $fileMode, array &$errors): void
{
    if (is_link($path)) {
        return;
    }

    if (is_file($path)) {
        if (! @chmod($path, $fileMode)) {
            $errors[] = "Gagal chmod file: {$path}";
        }

        return;
    }

    if (! is_dir($path)) {
        $errors[] = "Tidak ditemukan: {$path}";

        return;
    }

    if (! @chmod($path, $directoryMode)) {
        $errors[] = "Gagal chmod direktori: {$path}";
    }

    $entries = @scandir($path);
    if ($entries === false) {
        $errors[] = "Tidak dapat membaca direktori: {$path}";

        return;
    }

    foreach ($entries as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }

        fixTree($path.'/'.$entry, $directoryMode, $fileMode, $errors);
    }
}

$errors = [];

fixTree($laravelRoot, 0755, 0644, $errors);
fixTree($laravelRoot.'/storage', 0775, 0664, $errors);
fixTree($laravelRoot.'/bootstrap/cache', 0775, 0664, $errors);
fixTree($publicRoot.'/storage', 0775, 0664, $errors);
fixTree($publicRoot.'/vendor', 0755, 0644, $errors);

@chmod($laravelRoot.'/.env', 0600);
@chmod($laravelRoot.'/database/database.sqlite', 0664);

$checks = [
    'PHP >= 8.2' => version_compare(PHP_VERSION, '8.2.0', '>='),
    'pdo_sqlite' => extension_loaded('pdo_sqlite'),
    'SQLite database' => is_file($laravelRoot.'/database/database.sqlite'),
    'Composer autoload' => is_file($laravelRoot.'/vendor/autoload.php'),
    'Storage writable' => is_writable($laravelRoot.'/storage'),
    'Cache writable' => is_writable($laravelRoot.'/bootstrap/cache'),
];

echo "UISI hosting permission repair\n";
echo "PHP ".PHP_VERSION."\n\n";

foreach ($checks as $label => $passed) {
    echo ($passed ? '[OK] ' : '[GAGAL] ').$label."\n";
}

if ($errors !== []) {
    echo "\nPeringatan pertama:\n";
    foreach (array_slice($errors, 0, 20) as $error) {
        echo "- {$error}\n";
    }
    echo "Total peringatan: ".count($errors)."\n";
} else {
    echo "\nPermission berhasil diperbaiki.\n";
}

if (@unlink(__FILE__)) {
    echo "File perbaikan sudah terhapus otomatis.\n";
} else {
    echo "HAPUS MANUAL file public_html/fix-hosting-permissions.php.\n";
}
