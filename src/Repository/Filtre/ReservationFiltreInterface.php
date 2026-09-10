<?php

namespace App\Repository\Filtre;

use App\Model\Reservation;
use Illuminate\Database\Eloquent\Builder;

interface ReservationFiltreInterface
{
    public function estActif(array $criteres): bool;
    public function appliquerSurRequete(Builder $query, array $criteres): void;
    public function correspond(Reservation $reservation, array $criteres): bool;
}