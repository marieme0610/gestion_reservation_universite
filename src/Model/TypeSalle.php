<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;


class TypeSalle extends Model{

    public $timestamps = false;

    protected $fillable = ['nom'];

    protected $table = 'type_salle';

    public function salles(){
        return $this->hasMany(Salle::class,'type_salle_id');
    }
}