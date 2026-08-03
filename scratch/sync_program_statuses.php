<?php

$database = __DIR__.'/../database/database.sqlite';

if (! file_exists($database)) {
    fwrite(STDERR, "Database not found: {$database}\n");
    exit(1);
}

$pdo = new PDO('sqlite:'.$database);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->beginTransaction();

try {
    $pdo->exec(
        "UPDATE programs
         SET status = 'open_registration',
             is_registration_closed = 0
         WHERE status = 'coming_soon'
           AND COALESCE(quota, 0) > 0"
    );

    $pdo->exec(
        "UPDATE programs
         SET status = 'closed',
             is_registration_closed = 1
         WHERE COALESCE(quota, 0) <= 0"
    );

    $pdo->commit();
    echo "Program statuses synced for dashboard and CMS.\n";
} catch (Throwable $exception) {
    $pdo->rollBack();
    fwrite(STDERR, $exception->getMessage()."\n");
    exit(1);
}
