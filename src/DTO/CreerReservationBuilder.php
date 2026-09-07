<?php

namespace App\DTO;
use App\DTO\CreerReservationDTO;
use App\Validation\ValidatorInterface;

class CreerReservationBuilder{
    private function __construct(
        private ?int $salleId = null,
        private string $responsable = '',
        private string $email = '',
        private string $motif = '', 
        private ?\DateTimeImmutable $dateDebut = null,
        private ?\DateTimeImmutable $dateFin = null
    ) {}

    public static function create(): self
    {
        return new self();
    }
    public function salleId(int $salleId){ $this->salleId = $salleId; return $this;}
    public function responsable(string $responsable){$this->responsable = $responsable; return $this;}
    public function email(string $email){$this->email = $email; return $this;}
    public function motif(string $motif){$this->motif = $motif; return $this;}
    public function dateDebut(\DateTimeImmutable $dateDebut){$this->dateDebut = $dateDebut; return $this;}
    public function dateFin(\DateTimeImmutable $dateFin){$this->dateFin = $dateFin; return $this;}

    public function build(ValidatorInterface $validator): CreerReservationDTO
    {
        $data = [
            'salle_id'    => $this->salleId,
            'responsable' => $this->responsable,
            'email'       => $this->email,
            'motif'       => $this->motif,
            'date_debut'  => $this->dateDebut?->format('Y-m-d H:i:s'),
            'date_fin'    => $this->dateFin?->format('Y-m-d H:i:s'),
        ];

        return CreerReservationDTO::fromArray($validator, $data);
    }
}