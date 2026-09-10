<?php

namespace App\Repository\Filtre\Reservation;

use App\Model\Reservation;
use App\Repository\Filtre\ReservationFiltreInterface;
use Illuminate\Database\Eloquent\Builder;

class FiltreParSalle implements ReservationFiltreInterface
{
    public function estActif(array $criteres): bool
    {
        return !empty($criteres['salle_id']);
    }

    public function appliquerSurRequete(Builder $query, array $criteres): void
    {
        $query->where('salle_id', (int) $criteres['salle_id']);
    }

    public function correspond(Reservation $reservation, array $criteres): bool
    {
        return (int) $reservation->salle_id === (int) $criteres['salle_id'];
    }
}