<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\SessionManager;
use App\Exception\AccesRefuseException;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use App\Model\Utilisateur;
use App\Service\AuthService;
use PHPUnit\Framework\TestCase;
use Tests\Doubles\InMemoryUtilisateurRepository;

final class MiddlewareTest extends TestCase
{
    private AuthService $authService;

    protected function setUp(): void
    {
        $_SESSION = [];
        $utilisateurs = new InMemoryUtilisateurRepository();
        $this->authService = new AuthService($utilisateurs, new SessionManager());

        $admin = new Utilisateur([
            'nom' => 'Admin Test',
            'email' => 'admin@test.com',
            'mot_de_passe' => password_hash('secret', PASSWORD_DEFAULT),
            'role' => 'admin',
        ]);
        $admin->setAttribute('id', 1);
        $utilisateurs->ajouter($admin);

        $responsable = new Utilisateur([
            'nom' => 'Responsable Test',
            'email' => 'respo@test.com',
            'mot_de_passe' => password_hash('secret', PASSWORD_DEFAULT),
            'role' => 'responsable',
        ]);
        $responsable->setAttribute('id', 2);
        $utilisateurs->ajouter($responsable);
    }

    public function testAuthMiddlewareBloqueSiNonConnecte(): void
    {
        $middleware = new AuthMiddleware($this->authService);

        $this->expectException(AccesRefuseException::class);
        $middleware->verifier();
    }

    public function testAuthMiddlewareLaissePasserSiConnecte(): void
    {
        $this->authService->connecter('respo@test.com', 'secret');
        $middleware = new AuthMiddleware($this->authService);

        $middleware->verifier();
        $this->assertTrue(true);
    }

    public function testAdminMiddlewareBloqueUnResponsable(): void
    {
        $this->authService->connecter('respo@test.com', 'secret');
        $middleware = new AdminMiddleware($this->authService);

        $this->expectException(AccesRefuseException::class);
        $middleware->verifier();
    }

    public function testAdminMiddlewareLaissePasserUnAdmin(): void
    {
        $this->authService->connecter('admin@test.com', 'secret');
        $middleware = new AdminMiddleware($this->authService);

        $middleware->verifier();
        $this->assertTrue(true);
    }
}