<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Reservation extends Model{
    protected $table = 'reservations';

    protected $fillable = [
        'salle_id' ,
        'statut_reservation_id' ,
        'responsable' ,
        'email' ,
        'motif' ,
        'date_debut',
        'date_fin' 
    ];   
    
    protected $casts = [
        'salle_id' => 'int' ,
        'statut_reservation_id' => 'int',
        'date_debut' => 'datetime',
        'date_fin'  => 'datetime'
    ];

    //  public function salles(){
    //    return $this->belongsTo(Salle::class,'salle_id');
    // }

    public function statut(){
        return $this->belongsTo(StatutReservation::class,'statut_reservation_id');
    }

    public function salle(){
        return $this->belongsTo(Salle::class,'salle_id');
    }
    
}

