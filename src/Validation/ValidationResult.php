<?php

namespace App\Validation;

class ValidationResult{


    public function __construct(
        private bool $isValid,
        private array $errors = [],
        private array $data = []
    ) {}

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function hasError(string $field): bool
    {
        return isset($this->errors[$field]);
    }

    public function getError(string $field): ?string
    {
        return $this->errors[$field] ?? null;
    }
}
