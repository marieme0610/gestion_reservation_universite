<?php

namespace App\Factory;

use App\DTO\CreerReservationDTO;
use App\Model\Reservation;

class ReservationFactory
{
    private const STATUT_CONFIRMEE = 1;

    public static function creerDepuisDTO(CreerReservationDTO $dto): Reservation
    {
        $reservation = new Reservation();
        $reservation->salle_id = $dto->salleId;
        $reservation->statut_reservation_id = self::STATUT_CONFIRMEE;
        $reservation->responsable = $dto->responsable;
        $reservation->email = $dto->email;
        $reservation->motif = $dto->motif;
        $reservation->date_debut = $dto->dateDebut->format('Y-m-d H:i:s');
        $reservation->date_fin = $dto->dateFin->format('Y-m-d H:i:s');

        return $reservation;
    }
}