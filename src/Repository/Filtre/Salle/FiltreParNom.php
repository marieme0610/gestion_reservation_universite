<?php

namespace App\Repository\Filtre\Salle;

use App\Model\Salle;
use App\Repository\Filtre\SalleFiltreInterface;
use Illuminate\Database\Eloquent\Builder;

class FiltreParNom implements SalleFiltreInterface
{
    public function estActif(array $criteres): bool
    {
        return !empty($criteres['nom']);
    }

    public function appliquerSurRequete(Builder $query, array $criteres): void
    {
        $query->where('nom', 'like', '%' . $criteres['nom'] . '%');
    }

    public function correspond(Salle $salle, array $criteres): bool
    {
        return str_contains((string) $salle->nom, (string) $criteres['nom']);
    }
}