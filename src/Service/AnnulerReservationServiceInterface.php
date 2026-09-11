<?php

namespace App\Service;

interface AnnulerReservationServiceInterface
{
    public function annuler(int $reservationId): bool;
}