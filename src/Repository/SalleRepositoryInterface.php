<?php

namespace App\Repository;

use App\Model\Salle;

interface SalleRepositoryInterface{
    public function getAllSalle():array;
    public function findSalle(int $id):?Salle;
    public function saveSalle(Salle $salle):int;

}

