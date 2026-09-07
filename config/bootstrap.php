<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'driver'    => $_ENV['DB_DRIVER'] ?? 'mysql',
    'host'      => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'port'      => $_ENV['DB_PORT'] ?? '3306',
    'database'  => $_ENV['DB_DATABASE'] ?? '',
    'username'  => $_ENV['DB_USERNAME'] ?? '',
    'password'  => $_ENV['DB_PASSWORD'] ?? '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
];

$capsule = new Capsule();
$capsule->addConnection($config);

$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    Capsule::connection()->getPdo();
} catch (\PDOException $e) {
    error_log("Erreur de connexion BDD : " . $e->getMessage());
    die("Impossible de se connecter à la base de données. Veuillez vérifier la configuration.");
}
echo "Connexion à la base de données réussie !\n";