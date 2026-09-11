<?php

namespace App\DTO;

use App\Exception\ValidationException;
use App\Validation\ReservationValidatorInterface;

readonly class CreerReservationDTO
{
    private function __construct(
        public int $salleId,
        public string $responsable,
        public string $email,
        public ?string $motif, 
        public \DateTimeImmutable $dateDebut,
        public \DateTimeImmutable $dateFin
    ) {}

    public static function fromArray(ReservationValidatorInterface $validator, array $data): self    {

        $validationResult = $validator->validate($data);

        if (!$validationResult->isValid()) {
            throw new ValidationException($validationResult->errors());
        }

        $validatedData = $validationResult->data();
        return new self(
            salleId: (int) $validatedData['salle_id'],
            responsable: (string) $validatedData['responsable'],
            email: (string) $validatedData['email'],
            motif: $validatedData['motif'] ?? null,
            dateDebut: new \DateTimeImmutable($validatedData['date_debut']),
            dateFin: new \DateTimeImmutable($validatedData['date_fin'])
        );
    }
}