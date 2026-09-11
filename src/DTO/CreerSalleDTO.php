<?php

namespace App\DTO;
use App\Validation\SalleValidatorInterface;
use App\Exception\ValidationException;
readonly class CreerSalleDTO
{
    private function __construct(
        public string $nom,
        public string $batiment,
        public int $capacite,
        public bool $active,
        public int $typeSalleId
    ) {}

    public static function fromArray(SalleValidatorInterface $validator, array $data): self    {
         $validationResult = $validator->validate($data);

        if (!$validationResult->isValid()) {
            throw new ValidationException($validationResult->errors());
        }
        $validatedData = $validationResult->data();
        return new self(
            nom: (string) $validatedData['nom'],
            batiment: (string) $validatedData['batiment'],
            capacite: (int) $validatedData['capacite'],
            active: (bool) $validatedData['active'],
            typeSalleId: (int) $validatedData['type_salle_id']
        );
    }
}