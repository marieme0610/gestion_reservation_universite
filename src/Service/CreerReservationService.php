<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Exception\ReservationInvalideException;
use App\Factory\ReservationFactory;
use App\Service\Regle\ReservationRegleMetierInterface;

class CreerReservationService
{
   
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private ReservationRepositoryInterface $reservationRepository,
        private array $regles
    ) {}

    public function creatReservation(CreerReservationDTO $creerReservationDto): int
    {
        $salle = $this->salleRepository->findSalle($creerReservationDto->salleId);
        if (!$salle) {
            throw new ReservationInvalideException("Salle introuvable.");
        }

        foreach ($this->regles as $regle) {
            $regle->verifier($creerReservationDto, $salle, $this->reservationRepository);
        }

        $newReservation = ReservationFactory::creerDepuisDTO($creerReservationDto);

        return $this->reservationRepository->saveReservation($newReservation);
    }
}