<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;

// 1. Chargement variables d'environnement 
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 2. Configuration 
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

//  connexion Eloquent Design Pattern Singleton
$capsule = new Capsule();
$capsule->addConnection($config);

// Rendre Capsule disponible globalement pour les modèles Eloquent
$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    Capsule::connection()->getPdo();
} catch (\PDOException $e) {
    error_log("Erreur de connexion BDD : " . $e->getMessage());
    die("Impossible de se connecter à la base de données. Veuillez vérifier la configuration.");
}
// Tout en bas de bootstrap.php :
echo "Connexion à la base de données réussie !\n";