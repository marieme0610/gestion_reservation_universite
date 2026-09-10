<?php

namespace App\Service\Regle;

use App\DTO\CreerReservationDTO;
use App\Model\Salle;
use App\Repository\ReservationRepositoryInterface;
use App\Exception\ReservationInvalideException;

class RegleOrdreDates implements ReservationRegleMetierInterface
{
    public function verifier(CreerReservationDTO $dto, Salle $salle, ReservationRepositoryInterface $reservationRepository): void
    {
        if ($dto->dateDebut >= $dto->dateFin) {
            throw new ReservationInvalideException("La date de début doit être strictement antérieure à la date de fin.");
        }
    }
}