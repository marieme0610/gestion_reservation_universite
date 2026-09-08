<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

return [
    'driver'    => getenv('DB_DRIVER') ?: ($_ENV['DB_DRIVER'] ?? 'mysql'),
    'host'      => getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? '127.0.0.1'),
    'port'      => getenv('DB_PORT') ?: ($_ENV['DB_PORT'] ?? '3306'),
    'database'  => getenv('DB_DATABASE') ?: ($_ENV['DB_DATABASE'] ?? ''),
    'username'  => getenv('DB_USERNAME') ?: ($_ENV['DB_USERNAME'] ?? ''),
    'password'  => getenv('DB_PASSWORD') ?: ($_ENV['DB_PASSWORD'] ?? ''),
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
];
