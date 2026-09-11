<?php

return new class {
    public function run(): void
    {
        echo " Début de l'exécution globale des Seeders...\n";

        $seeders = [
            'TypeSalleSeeder.php',
            'StatutReservationSeeder.php',
            'SalleSeeder.php',
            'UtilisateurSeeder.php',
        ];

        foreach ($seeders as $file) {
            $path = __DIR__ . '/' . $file;
            if (file_exists($path)) {
                $seeder = require $path;
                if (is_object($seeder) && method_exists($seeder, 'run')) {
                    $seeder->run();
                }
            } else {
                echo "Seeder introuvable : {$file}\n";
            }
        }

        echo "Tous les Seeders ont été exécutés avec succès !\n";
    }
};