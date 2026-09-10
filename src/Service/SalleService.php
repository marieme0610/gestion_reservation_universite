<?php

namespace App\Service;

use App\DTO\CreerSalleDTO;
use App\Model\Salle;
use App\Model\TypeSalle;
use App\Repository\SalleRepositoryInterface;
use App\Factory\SalleFactory;
use App\Support\PaginationResult;

class SalleService
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository
    ) {}

    public function rechercherEtPaginer(array $criteres, int $page, int $parPage): PaginationResult
    {
        return $this->salleRepository->rechercherEtPaginer($criteres, $page, $parPage);
    }

    public function trouver(int $id): ?Salle
    {
        return $this->salleRepository->findSalle($id);
    }

    public function creer(CreerSalleDTO $dto): int
    {
        $salle = SalleFactory::creerDepuisDTO($dto);
        return $this->salleRepository->saveSalle($salle);
    }

    public function modifier(Salle $salle, CreerSalleDTO $dto): int
    {
        SalleFactory::remplirDepuisDTO($salle, $dto);
        return $this->salleRepository->saveSalle($salle);
    }

    public function listerTypes(): array
    {
        return TypeSalle::all()->all();
    }
}