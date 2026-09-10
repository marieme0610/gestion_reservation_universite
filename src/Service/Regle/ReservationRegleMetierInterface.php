<?php

namespace App\Service\Regle;

use App\DTO\CreerReservationDTO;
use App\Model\Salle;
use App\Repository\ReservationRepositoryInterface;


interface ReservationRegleMetierInterface
{
    public function verifier(
        CreerReservationDTO $dto,
        Salle $salle,
        ReservationRepositoryInterface $reservationRepository
    ): void;
}