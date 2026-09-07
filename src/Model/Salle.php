<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use App\Model\Reservation;
use App\Model\TypeSalle;

class Salle extends Model{
    protected $table = 'salles';

    protected $fillable = [
        'nom',
        'batiment',
        'capacite',
        'active',
        'type_salle_id'
    ];

    protected $casts = [
        'capacite'=> 'int',
        'active' => 'boolean',
        'type_salle_id' => 'int'
    ];

    public function typeSalle()
    {
        return $this->belongsTo(TypeSalle::class, 'type_salle_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'salle_id');
    }

}

