<?php

namespace App\Middleware;

use App\Service\AuthService;
use App\Exception\AccesRefuseException;

class AdminMiddleware implements MiddlewareInterface
{
    public function __construct(private AuthService $authService) {}

    public function verifier(): void
    {
        if (!$this->authService->estAdmin()) {
            throw new AccesRefuseException("Accès réservé aux administrateurs.", '/salles');
        }
    }
}