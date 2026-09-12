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

use Illuminate\Pagination\Paginator;

Paginator::currentPageResolver(function (string $pageName = 'page') {
    return (int) ($_GET[$pageName] ?? 1);
});

if (($_ENV['AUTO_MIGRATE'] ?? 'false') === 'true') {
    $flagFile = sys_get_temp_dir() . '/migrated.flag';
    if (!file_exists($flagFile)) {
        try {
            exec('php ' . __DIR__ . '/../marieme:migrate 2>&1', $output, $code);
            exec('php ' . __DIR__ . '/../marieme:seed 2>&1', $output2, $code2);
            file_put_contents($flagFile, date('c'));
        } catch (\Throwable $e) {
            error_log('Auto-migrate a échoué : ' . $e->getMessage());
        }
    }
}
