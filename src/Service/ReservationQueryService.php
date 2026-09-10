<?php

namespace App\Service;

use App\Model\Reservation;
use App\Model\Salle;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Support\PaginationResult;


class ReservationQueryService
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private SalleRepositoryInterface $salleRepository
    ) {}

    public function rechercherEtPaginer(array $criteres, int $page, int $parPage): PaginationResult
    {
        return $this->reservationRepository->rechercherEtPaginer($criteres, $page, $parPage);
    }

    public function trouver(int $id): ?Reservation
    {
        return $this->reservationRepository->findReservation($id);
    }

  
    public function listerSallesDisponibles(): array
    {
        return $this->salleRepository->getAllSalle();
    }
}