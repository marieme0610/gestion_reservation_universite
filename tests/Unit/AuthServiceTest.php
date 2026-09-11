<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\SessionManager;
use App\Exception\IdentifiantsInvalidesException;
use App\Model\Utilisateur;
use App\Service\AuthService;
use PHPUnit\Framework\TestCase;
use Tests\Doubles\InMemoryUtilisateurRepository;

final class AuthServiceTest extends TestCase
{
    private InMemoryUtilisateurRepository $utilisateurs;
    private AuthService $authService;

    protected function setUp(): void
    {
        $_SESSION = [];
        $this->utilisateurs = new InMemoryUtilisateurRepository();
        $this->authService = new AuthService($this->utilisateurs, new SessionManager());

        $utilisateur = new Utilisateur([
            'nom' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'mot_de_passe' => password_hash('secret123', PASSWORD_DEFAULT),
            'role' => 'responsable',
        ]);
        $utilisateur->setAttribute('id', 1);
        $this->utilisateurs->ajouter($utilisateur);
    }

    public function testConnexionValide(): void
    {
        $this->authService->connecter('jean@example.com', 'secret123');

        $this->assertTrue($this->authService->estConnecte());
        $this->assertSame('Jean Dupont', $this->authService->nomUtilisateurConnecte());
        $this->assertFalse($this->authService->estAdmin());
    }

    public function testMotDePasseIncorrect(): void
    {
        $this->expectException(IdentifiantsInvalidesException::class);
        $this->authService->connecter('jean@example.com', 'mauvais-mot-de-passe');
    }

    public function testEmailInconnu(): void
    {
        $this->expectException(IdentifiantsInvalidesException::class);
        $this->authService->connecter('inconnu@example.com', 'peu-importe');
    }

    public function testDeconnexion(): void
    {
        $this->authService->connecter('jean@example.com', 'secret123');
        $this->authService->deconnecter();

        $this->assertFalse($this->authService->estConnecte());
    }
}