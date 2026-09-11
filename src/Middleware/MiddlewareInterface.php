<?php

namespace App\Middleware;

interface MiddlewareInterface
{
    public function verifier(): void;
}