<?php

namespace App\Exception;

class IdentifiantsInvalidesException extends \Exception
{
    public function __construct(string $message = "Email ou mot de passe incorrect.")
    {
        parent::__construct($message);
    }
}