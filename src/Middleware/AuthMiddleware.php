<?php

namespace App\Middleware;

use App\Service\AuthService;
use App\Exception\AccesRefuseException;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(private AuthService $authService) {}

    public function verifier(): void
    {
        if (!$this->authService->estConnecte()) {
            throw new AccesRefuseException("Vous devez être connecté pour accéder à cette page.", '/login');
        }
    }
}