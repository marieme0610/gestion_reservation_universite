<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$config = require __DIR__ . '/database.php';

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
