<?php

namespace App\Repository;

use App\Model\Salle;
use App\Support\PaginationResult;

interface SalleRepositoryInterface{
    public function getAllSalle():array;
    public function findSalle(int $id):?Salle;
    public function saveSalle(Salle $salle):int;
    public function rechercherEtPaginer(array $criteres, int $page, int $parPage): PaginationResult;

}

