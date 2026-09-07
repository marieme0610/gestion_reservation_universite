<?php

namespace App\DTO;

use DateTimeImmutable;

readonly class CreerReservationDTO
{
    private function __construct(
        public int $salleId,
        public string $responsable,
        public string $email,
        public ?string $motif, 
        public DateTimeImmutable $dateDebut,
        public DateTimeImmutable $dateFin
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            salleId: (int) $data['salle_id'],
            responsable: (string) $data['responsable'],
            email: (string) $data['email'],
            motif: $data['motif'] ?? null,
            dateDebut: new DateTimeImmutable($data['date_debut']),
            dateFin: new DateTimeImmutable($data['date_fin'])
        );
    }
}