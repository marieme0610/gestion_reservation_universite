<?php

namespace App\DTO;

use App\Validation\ValidatorInterface;

/**
 * Builder : assemble étape par étape les données brutes d'une réservation
 * avant de les soumettre à la validation. Les setters acceptent des valeurs
 * "mixed" volontairement : à ce stade rien n'est encore validé (une date
 * mal formée ou un champ vide doivent produire une erreur de validation
 * propre, pas une erreur PHP fatale avant même d'arriver au validateur).
 */
class CreerReservationBuilder
{
    private function __construct(
        private mixed $salleId = null,
        private mixed $responsable = '',
        private mixed $email = '',
        private mixed $motif = '',
        private mixed $dateDebut = '',
        private mixed $dateFin = ''
    ) {}

    public static function create(): self
    {
        return new self();
    }

    public function salleId(mixed $salleId): self
    {
        $this->salleId = $salleId;
        return $this;
    }

    public function responsable(mixed $responsable): self
    {
        $this->responsable = $responsable;
        return $this;
    }

    public function email(mixed $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function motif(mixed $motif): self
    {
        $this->motif = $motif;
        return $this;
    }

    public function dateDebut(mixed $dateDebut): self
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function dateFin(mixed $dateFin): self
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function build(ValidatorInterface $validator): CreerReservationDTO
    {
        $data = [
            'salle_id'    => $this->salleId,
            'responsable' => $this->responsable,
            'email'       => $this->email,
            'motif'       => $this->motif,
            'date_debut'  => $this->dateDebut,
            'date_fin'    => $this->dateFin,
        ];

        return CreerReservationDTO::fromArray($validator, $data);
    }
}