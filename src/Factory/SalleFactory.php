<?php

namespace App\Factory;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;

class SalleFactory
{
    public static function creerDepuisDTO(CreerSalleDTO $dto): Salle
    {
        return self::remplirDepuisDTO(new Salle(), $dto);
    }

    public static function remplirDepuisDTO(Salle $salle, CreerSalleDTO $dto): Salle
    {
        $salle->nom = $dto->nom;
        $salle->batiment = $dto->batiment;
        $salle->capacite = $dto->capacite;
        $salle->active = $dto->active;
        $salle->type_salle_id = $dto->typeSalleId;

        return $salle;
    }
}