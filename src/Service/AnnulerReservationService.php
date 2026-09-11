<?php

namespace App\Service;

use App\Repository\ReservationRepositoryInterface;
use App\Exception\ReservationIntrouvableException;

class AnnulerReservationService implements AnnulerReservationServiceInterface
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository
    ) {}

    public function annuler(int $reservationId): bool
    {
        $reservation = $this->reservationRepository->findReservation($reservationId);

        if (!$reservation) {
            throw new ReservationIntrouvableException("Impossible d'annuler : la réservation #{$reservationId} n'existe pas.");
        }

        return $this->reservationRepository->annulerReservation($reservationId);
    }
}