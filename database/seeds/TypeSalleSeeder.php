<?php

use App\Model\TypeSalle;

return new class {
    public function run(): void
    {
        $types = [
            'Amphithéâtre',
            'Salle de cours',
            'Laboratoire',
            'Informatique',
            'Réunion'
        ];

        foreach ($types as $nom) {
            // firstOrCreate vérifie si l'enregistrement existe déjà avant d'insérer
            TypeSalle::firstOrCreate(['nom' => $nom]);
        }

        echo "  TypeSalleSeeder : catégories de salles traitées.\n";
    }
};