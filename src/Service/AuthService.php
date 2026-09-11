<?php

namespace App\Service;

use App\Core\SessionManager;
use App\Repository\UtilisateurRepositoryInterface;
use App\Exception\IdentifiantsInvalidesException;

class AuthService
{
    public function __construct(
        private UtilisateurRepositoryInterface $utilisateurRepository,
        private SessionManager $session
    ) {}

    public function connecter(string $email, string $motDePasse): void
    {
        $utilisateur = $this->utilisateurRepository->findParEmail($email);

        if (!$utilisateur || !password_verify($motDePasse, $utilisateur->mot_de_passe)) {
            throw new IdentifiantsInvalidesException();
        }

        $this->session->set('auth_id', $utilisateur->id);
        $this->session->set('auth_nom', $utilisateur->nom);
        $this->session->set('auth_role', $utilisateur->role);
    }

    public function deconnecter(): void
    {
        $this->session->unset('auth_id');
        $this->session->unset('auth_nom');
        $this->session->unset('auth_role');
    }

    public function estConnecte(): bool
    {
        return $this->session->get('auth_id') !== null;
    }

    public function estAdmin(): bool
    {
        return $this->session->get('auth_role') === 'admin';
    }

    public function nomUtilisateurConnecte(): ?string
    {
        return $this->session->get('auth_nom');
    }
}