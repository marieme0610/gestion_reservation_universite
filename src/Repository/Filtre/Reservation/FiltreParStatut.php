<?php

namespace App\Repository\Filtre\Reservation;

use App\Model\Reservation;
use App\Repository\Filtre\ReservationFiltreInterface;
use Illuminate\Database\Eloquent\Builder;

class FiltreParStatut implements ReservationFiltreInterface
{
    public function estActif(array $criteres): bool
    {
        return !empty($criteres['statut_reservation_id']);
    }

    public function appliquerSurRequete(Builder $query, array $criteres): void
    {
        $query->where('statut_reservation_id', (int) $criteres['statut_reservation_id']);
    }

    public function correspond(Reservation $reservation, array $criteres): bool
    {
        return (int) $reservation->statut_reservation_id === (int) $criteres['statut_reservation_id'];
    }
}