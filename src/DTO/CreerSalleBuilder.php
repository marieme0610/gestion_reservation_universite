<?php

namespace App\DTO;

use App\DTO\CreerSalleDTO;
use App\Validation\ValidatorInterface;

class CreerSalleBuilder
{
    private function __construct(
        public ?string $nom = null,
        public ?string $batiment = null,
        public ?int $capacite = null,
        public ?bool $active = null,
        public ?int $typeSalleId = null
    ) {}

    public static function create(): self
    {
        return new self();
    }

    public function nom(string $nom)
    {
        $this->nom = $nom;
        return $this;
    }
    public function batiment(string $batiment)
    {
        $this->batiment = $batiment;
        return $this;
    }
    public function capacite(int $capacite)
    {
        $this->capacite = $capacite;
        return $this;
    }
    public function active(bool $active)
    {
        $this->active = $active;
        return $this;
    }
    public function typeSalleId(int $typeSalleId)
    {
        $this->typeSalleId = $typeSalleId;
        return $this;
    }

    public function build(ValidatorInterface $validator): CreerSalleDTO
    {
        $data = [
            'nom' => $this->nom,
            'batiment' => $this->batiment,
            'capacite' => $this->capacite,
            'active' => $this->active,
            'type_salle_id' => $this->typeSalleId,
        ];

        return CreerSalleDTO::fromArray($validator, $data);
    }
}
