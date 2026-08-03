<?php

$database = __DIR__.'/../database/database.sqlite';
$email = 'admin@uisi.ac.id';
$password = 'Admin@12345!';

if (! file_exists($database)) {
    fwrite(STDERR, "Database not found: {$database}\n");
    exit(1);
}

$pdo = new PDO('sqlite:'.$database);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$columns = $pdo->query('PRAGMA table_info(users)')->fetchAll(PDO::FETCH_ASSOC);
$hasIsAdmin = false;

foreach ($columns as $column) {
    if ($column['name'] === 'is_admin') {
        $hasIsAdmin = true;
        break;
    }
}

if (! $hasIsAdmin) {
    $pdo->exec('ALTER TABLE users ADD COLUMN is_admin TINYINT(1) NOT NULL DEFAULT 0');
}

$now = date('Y-m-d H:i:s');
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
$existing = $pdo->prepare('SELECT id, email, is_admin FROM users WHERE email = :email LIMIT 1');
$existing->execute(['email' => $email]);
$user = $existing->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $statement = $pdo->prepare(
        'UPDATE users
         SET name = :name,
             password = :password,
             is_admin = 1,
             email_verified_at = COALESCE(email_verified_at, :verified_at),
             updated_at = :updated_at
         WHERE email = :email'
    );

    $statement->execute([
        'name' => 'Admin UISI',
        'password' => $hash,
        'verified_at' => $now,
        'updated_at' => $now,
        'email' => $email,
    ]);

    echo "Admin user updated: {$email}\n";
} else {
    $statement = $pdo->prepare(
        'INSERT INTO users (name, email, email_verified_at, password, is_admin, created_at, updated_at)
         VALUES (:name, :email, :email_verified_at, :password, 1, :created_at, :updated_at)'
    );

    $statement->execute([
        'name' => 'Admin UISI',
        'email' => $email,
        'email_verified_at' => $now,
        'password' => $hash,
        'created_at' => $now,
        'updated_at' => $now,
    ]);

    echo "Admin user created: {$email}\n";
}

$check = $pdo->prepare('SELECT id, name, email, is_admin, email_verified_at, password FROM users WHERE email = :email LIMIT 1');
$check->execute(['email' => $email]);
$admin = $check->fetch(PDO::FETCH_ASSOC);

echo 'Password check: '.(password_verify($password, $admin['password']) ? 'OK' : 'FAILED')."\n";
echo 'Admin flag: '.$admin['is_admin']."\n";
