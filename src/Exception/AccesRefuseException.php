<?php

namespace App\Exception;

class AccesRefuseException extends \Exception
{
    public function __construct(string $message, public readonly string $redirectTo)
    {
        parent::__construct($message);
    }
}