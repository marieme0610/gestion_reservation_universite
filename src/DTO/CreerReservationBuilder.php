<?php

namespace App\DTO;

use App\Validation\ReservationValidatorInterface;

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

    public function build(ReservationValidatorInterface $validator): CreerReservationDTO
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