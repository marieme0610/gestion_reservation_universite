<?php

namespace App\Repository;

use App\Model\Utilisateur;

class UtilisateurRepository implements UtilisateurRepositoryInterface
{
    public function findParEmail(string $email): ?Utilisateur
    {
        return Utilisateur::where('email', $email)->first();
    }
}