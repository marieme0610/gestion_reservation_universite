<?php

declare(strict_types=1);

namespace Tests\Doubles;

use App\Model\Utilisateur;
use App\Repository\UtilisateurRepositoryInterface;

final class InMemoryUtilisateurRepository implements UtilisateurRepositoryInterface
{
    /** @var array<Utilisateur> */
    private array $utilisateurs = [];

    public function ajouter(Utilisateur $utilisateur): void
    {
        $this->utilisateurs[] = $utilisateur;
    }

    public function findParEmail(string $email): ?Utilisateur
    {
        foreach ($this->utilisateurs as $utilisateur) {
            if ($utilisateur->email === $email) {
                return $utilisateur;
            }
        }
        return null;
    }
}