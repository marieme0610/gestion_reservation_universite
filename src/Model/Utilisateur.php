<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $table = 'utilisateurs';

    protected $fillable = ['nom', 'email', 'mot_de_passe', 'role'];

    protected $hidden = ['mot_de_passe'];
}