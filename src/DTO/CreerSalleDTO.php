<?php

namespace App\DTO;

readonly class CreerSalleDTO
{
    private function __construct(
        public string $nom,
        public string $batiment,
        public int $capacite,
        public bool $active,
        public int $typeSalleId
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nom: (string) $data['nom'],
            batiment: (string) $data['batiment'],
            capacite: (int) $data['capacite'],
            active: (bool) $data['active'],
            typeSalleId: (int) $data['type_salle_id']
        );
    }
}