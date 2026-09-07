<?php

require_once dirname(__DIR__) . "/config/bootstrap.php";

use App\Model\TypeSalle;
use App\Model\StatutReservation;
use App\Model\Salle;
use App\Model\Reservation;

try {
    echo "--- Début du Seeding ---\n";

    $typeAmphi = TypeSalle::firstOrCreate(['nom' => 'Amphithéâtre']);
    $typeCours = TypeSalle::firstOrCreate(['nom' => 'Salle de cours']);
    $typeLabo  = TypeSalle::firstOrCreate(['nom' => 'Laboratoire']);
    $typeInfo  = TypeSalle::firstOrCreate(['nom' => 'Informatique']);
    $typeReun  = TypeSalle::firstOrCreate(['nom' => 'Réunion']);
    echo "Types de salles configurés.\n";

    $confirme  = StatutReservation::firstOrCreate(['nom' => 'Confirmée']);
    $annule    = StatutReservation::firstOrCreate(['nom' => 'Annulée']);
    echo "Statuts de réservation configurés.\n";

    $salles = [
        ['nom' => 'Amphithéâtre A', 'type_salle_id' => $typeAmphi->id, 'capacite' => 250, 'batiment' => 'Bâtiment Principal'],
        ['nom' => 'Salle B12', 'type_salle_id' => $typeCours->id, 'capacite' => 40, 'batiment' => 'Bâtiment B'],
        ['nom' => 'Laboratoire Chimie', 'type_salle_id' => $typeLabo->id, 'capacite' => 24, 'batiment' => 'Bloc Sciences'],
        ['nom' => 'Salle Informatique 1', 'type_salle_id' => $typeInfo->id, 'capacite' => 30, 'batiment' => 'Bâtiment C'],
        ['nom' => 'Salle de réunion', 'type_salle_id' => $typeReun->id, 'capacite' => 12, 'batiment' => 'Administration'],
    ];

    foreach ($salles as $dataSalle) {
        $salle = Salle::create($dataSalle);
        echo "Salle ajoutée : {$salle->nom} ({$salle->capacite} places)\n";
    }

    echo "--- Seeding terminé avec succès ! ---\n";

} catch (\Exception $e) {
    echo "❌ Erreur lors du seeding : " . $e->getMessage() . "\n";
}