<?php

$database = __DIR__.'/../database/database.sqlite';
$pdo = new PDO('sqlite:'.$database);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$columns = $pdo->query('PRAGMA table_info(programs)')->fetchAll(PDO::FETCH_ASSOC);
$names = array_column($columns, 'name');
$select = array_values(array_intersect([
    'id',
    'title',
    'category',
    'faculty',
    'image_url',
    'registration_date',
    'quota',
    'total_quota',
    'publish_date',
    'registration_open_date',
    'event_date',
    'status',
    'is_registration_closed',
], $names));

$programs = $pdo->query(
    'SELECT '.implode(', ', $select).'
     FROM programs
     ORDER BY id'
)->fetchAll(PDO::FETCH_ASSOC);

foreach ($programs as $program) {
    echo json_encode($program, JSON_UNESCAPED_SLASHES).PHP_EOL;
}
