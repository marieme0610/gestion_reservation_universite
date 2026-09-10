<?php

namespace App\Repository\Filtre;

use App\Model\Salle;
use Illuminate\Database\Eloquent\Builder;

interface SalleFiltreInterface
{
    public function estActif(array $criteres): bool;
    public function appliquerSurRequete(Builder $query, array $criteres): void;
    public function correspond(Salle $salle, array $criteres): bool;
}