<?php

use App\Model\Salle;
use App\Model\TypeSalle;

return new class {
    public function run(): void
    {
        $typeAmphi = TypeSalle::where('nom', 'Amphithéâtre')->first();
        $typeCours = TypeSalle::where('nom', 'Salle de cours')->first();
        $typeLabo  = TypeSalle::where('nom', 'Laboratoire')->first();
        $typeInfo  = TypeSalle::where('nom', 'Informatique')->first();
        $typeReun  = TypeSalle::where('nom', 'Réunion')->first();

        $salles = [
            ['nom' => 'Amphithéâtre A', 'type_salle_id' => $typeAmphi?->id, 'capacite' => 250, 'batiment' => 'Bâtiment Principal'],
            ['nom' => 'Salle B12', 'type_salle_id' => $typeCours?->id, 'capacite' => 40, 'batiment' => 'Bâtiment B'],
            ['nom' => 'Laboratoire Chimie', 'type_salle_id' => $typeLabo?->id, 'capacite' => 24, 'batiment' => 'Bloc Sciences'],
            ['nom' => 'Salle Informatique 1', 'type_salle_id' => $typeInfo?->id, 'capacite' => 30, 'batiment' => 'Bâtiment C'],
            ['nom' => 'Salle de réunion', 'type_salle_id' => $typeReun?->id, 'capacite' => 12, 'batiment' => 'Administration'],
        ];

        foreach ($salles as $data) {
            Salle::firstOrCreate(['nom' => $data['nom']], $data);
        }

        echo "  SalleSeeder : salles traitées.\n";
    }
};