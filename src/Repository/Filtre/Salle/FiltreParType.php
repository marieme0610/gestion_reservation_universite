<?php

namespace App\Repository\Filtre\Salle;

use App\Model\Salle;
use App\Repository\Filtre\SalleFiltreInterface;
use Illuminate\Database\Eloquent\Builder;

class FiltreParType implements SalleFiltreInterface
{
    public function estActif(array $criteres): bool
    {
        return !empty($criteres['type_salle_id']);
    }

    public function appliquerSurRequete(Builder $query, array $criteres): void
    {
        $query->where('type_salle_id', (int) $criteres['type_salle_id']);
    }

    public function correspond(Salle $salle, array $criteres): bool
    {
        return (int) $salle->type_salle_id === (int) $criteres['type_salle_id'];
    }
}