<?php

namespace App\Repository;
use App\Model\Reservation;
use App\Model\StatutReservation;

class ReservationRepository implements ReservationRepositoryInterface{
    public function getAllReservation():array{
        
        return Reservation::all()->all();
    }
    public function findReservation(int $id):?Reservation{
        return Reservation::find($id);
    }
    public function saveReservation(Reservation $reservation):int{
        $reservation->save();
        return (int)$reservation->id;
    }
    public function annulerReservation(int $id): bool
{
    $reservation = Reservation::find($id);

    if (!$reservation) {
        return false;
    }

    $reservation->statut_reservation_id = 2;

    return $reservation->save();
}

    public function chercherConflit( int $salleId, \DateTimeImmutable $dateDebut,\DateTimeImmutable $dateFin): bool {
   
    return Reservation::where('salle_id', $salleId)
        ->where('statut_reservation_id', '!=', 2)
        ->where('date_debut', '<', $dateFin->format('Y-m-d H:i:s'))
        ->where('date_fin', '>', $dateDebut->format('Y-m-d H:i:s'))
        ->exists();
}
}