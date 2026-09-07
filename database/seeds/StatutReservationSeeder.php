<?php

use App\Model\StatutReservation;

return new class {
    public function run(): void
    {
        $statuts = ['Confirmée', 'Annulée', 'En attente'];

        foreach ($statuts as $nom) {
            StatutReservation::firstOrCreate(['nom' => $nom]);
        }

        echo "  StatutReservationSeeder : statuts de réservation traités.\n";
    }
};