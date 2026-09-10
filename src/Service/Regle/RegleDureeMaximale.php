<?php

namespace App\Service\Regle;

use App\DTO\CreerReservationDTO;
use App\Model\Salle;
use App\Repository\ReservationRepositoryInterface;
use App\Exception\ReservationInvalideException;

class RegleDureeMaximale implements ReservationRegleMetierInterface
{
    private const DUREE_MAX_SECONDES = 14400; // 4 heures

    public function verifier(CreerReservationDTO $dto, Salle $salle, ReservationRepositoryInterface $reservationRepository): void
    {
        $duree = $dto->dateFin->getTimestamp() - $dto->dateDebut->getTimestamp();

        if ($duree > self::DUREE_MAX_SECONDES) {
            throw new ReservationInvalideException("La durée d'une réservation ne peut pas dépasser 4 heures.");
        }
    }
}