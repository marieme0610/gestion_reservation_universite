<?php

namespace App\Repository;

use App\Model\Reservation;
use App\Support\PaginationResult;

interface ReservationRepositoryInterface{
    public function getAllReservation():array;
    public function findReservation(int $id):?Reservation;
    public function saveReservation(Reservation $reservation):int;
    public function annulerReservation(int $id):bool;
    public function chercherConflit(
        int $salleId,
        \DateTimeImmutable $dateDebut,
        \DateTimeImmutable $dateFin
    ): bool;


      public function rechercherEtPaginer(array $criteres, int $page, int $parPage): PaginationResult;
}