<?php

namespace App\Service;

use App\Model\Reservation;
use App\DTO\CreerReservationDTO;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Exception\SalleIndisponibleException;
use App\Exception\ReservationInvalideException;
use DateTimeImmutable;

class CreerReservationService
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private ReservationRepositoryInterface $reservationRepository
    ) {}

    public function creatReservation(CreerReservationDTO $creerReservationDto): int
    {
        $salle_id = $creerReservationDto->salleId;
        $responsable = $creerReservationDto->responsable;
        $email = $creerReservationDto->email;
        $motif = $creerReservationDto->motif;
        $debut = $creerReservationDto->dateDebut;
        $fin = $creerReservationDto->dateFin;

        $salle = $this->salleRepository->findSalle($salle_id);
        if (!$salle) {
            throw new ReservationInvalideException("Salle introuvable.");
        }

        if (!$salle->active) {
            throw new SalleIndisponibleException("Cette salle est inactive.");
        }

        if ($debut >= $fin) {
            throw new ReservationInvalideException("La date de début doit être strictement antérieure à la date de fin.");
        }

        $duree = $fin->getTimestamp() - $debut->getTimestamp();
        if ($duree > 14400) {
            throw new ReservationInvalideException("La durée d'une réservation ne peut pas dépasser 4 heures.");
        }

        $maintenant = new DateTimeImmutable();
        if ($debut <= $maintenant) {
            throw new ReservationInvalideException("La date de réservation doit être dans le futur.");
        }

        $conflit = $this->reservationRepository->chercherConflit($salle_id, $debut, $fin);
        if ($conflit) {
            throw new SalleIndisponibleException("La salle est déjà réservée sur ce créneau horaire.");
        }

        $newReservation = new Reservation();
        $newReservation->salle_id = $salle_id;
        $newReservation->statut_reservation_id = 1;
        $newReservation->responsable = $responsable;
        $newReservation->email = $email;
        $newReservation->motif = $motif;
        $newReservation->date_debut = $debut->format('Y-m-d H:i:s');
        $newReservation->date_fin = $fin->format('Y-m-d H:i:s');

        return $this->reservationRepository->saveReservation($newReservation);
    }
}