<?php

namespace App\Exception;

use Exception;

class ValidationException extends Exception
{
    public function __construct(
        private array $errors,
        string $message = "Les données fournies sont invalides."
    ) {
        parent::__construct($message);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}