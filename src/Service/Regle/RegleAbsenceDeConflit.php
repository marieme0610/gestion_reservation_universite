<?php

namespace App\Service\Regle;

use App\DTO\CreerReservationDTO;
use App\Model\Salle;
use App\Repository\ReservationRepositoryInterface;
use App\Exception\SalleIndisponibleException;

class RegleAbsenceDeConflit implements ReservationRegleMetierInterface
{
    public function verifier(CreerReservationDTO $dto, Salle $salle, ReservationRepositoryInterface $reservationRepository): void
    {
        $conflit = $reservationRepository->chercherConflit($dto->salleId, $dto->dateDebut, $dto->dateFin);

        if ($conflit) {
            throw new SalleIndisponibleException("La salle est déjà réservée sur ce créneau horaire.");
        }
    }
}