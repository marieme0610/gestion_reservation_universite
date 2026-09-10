<?php

namespace App\DTO;

use App\Validation\ValidatorInterface;

class CreerSalleBuilder
{
    private function __construct(
        private mixed $nom = '',
        private mixed $batiment = '',
        private mixed $capacite = null,
        private mixed $active = null,
        private mixed $typeSalleId = null
    ) {}

    public static function create(): self
    {
        return new self();
    }

    public function nom(mixed $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function batiment(mixed $batiment): self
    {
        $this->batiment = $batiment;
        return $this;
    }

    public function capacite(mixed $capacite): self
    {
        $this->capacite = $capacite;
        return $this;
    }

    public function active(mixed $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function typeSalleId(mixed $typeSalleId): self
    {
        $this->typeSalleId = $typeSalleId;
        return $this;
    }

    public function build(ValidatorInterface $validator): CreerSalleDTO
    {
        $data = [
            'nom'           => $this->nom,
            'batiment'      => $this->batiment,
            'capacite'      => $this->capacite,
            'active'        => $this->active,
            'type_salle_id' => $this->typeSalleId,
        ];

        return CreerSalleDTO::fromArray($validator, $data);
    }
}