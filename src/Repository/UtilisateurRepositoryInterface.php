<?php

namespace App\Repository;

use App\Model\Utilisateur;

interface UtilisateurRepositoryInterface
{
    public function findParEmail(string $email): ?Utilisateur;
}