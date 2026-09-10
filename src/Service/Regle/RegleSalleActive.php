<?php

namespace App\Service\Regle;

use App\DTO\CreerReservationDTO;
use App\Model\Salle;
use App\Repository\ReservationRepositoryInterface;
use App\Exception\SalleIndisponibleException;

class RegleSalleActive implements ReservationRegleMetierInterface
{
    public function verifier(CreerReservationDTO $dto, Salle $salle, ReservationRepositoryInterface $reservationRepository): void
    {
        if (!$salle->active) {
            throw new SalleIndisponibleException("Cette salle est inactive.");
        }
    }
}