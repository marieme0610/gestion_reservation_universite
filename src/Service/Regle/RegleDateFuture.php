<?php

namespace App\Service\Regle;

use App\DTO\CreerReservationDTO;
use App\Model\Salle;
use App\Repository\ReservationRepositoryInterface;
use App\Exception\ReservationInvalideException;
use DateTimeImmutable;

class RegleDateFuture implements ReservationRegleMetierInterface
{
    public function verifier(CreerReservationDTO $dto, Salle $salle, ReservationRepositoryInterface $reservationRepository): void
    {
        if ($dto->dateDebut <= new DateTimeImmutable()) {
            throw new ReservationInvalideException("La date de réservation doit être dans le futur.");
        }
    }
}