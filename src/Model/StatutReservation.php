<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class StatutReservation extends Model{

   protected $table = 'statut_reservation';

   public $timestamps = false;

   protected $fillable = ['nom'];

    public function reservations(){
        $this->hasMany(Reservation::class,'statut_reservation_id');
    }
}

