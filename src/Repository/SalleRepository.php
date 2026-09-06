<?php

use App\Repository\SalleRepositoryInterface;
use App\Model\Salle;

class SalleRepository implements SalleRepositoryInterface{
    public function getAllSalle():array{
       return Salle::all()->all();
        
    }
    public function findSalle(int $id):?Salle{
       return Salle::find($id);
    }
    public function saveSalle(Salle $salle):int{
       $salle->save();
        return (int)$salle->id;
    }
}