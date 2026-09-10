<?php

declare(strict_types=1);

namespace Tests\Doubles;

use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;
use App\Repository\Filtre\Salle\FiltreParNom;
use App\Repository\Filtre\Salle\FiltreParType;
use App\Support\PaginationResult;

final class InMemorySalleRepository implements SalleRepositoryInterface
{
    /** @var array<int, Salle> */
    private array $salles = [];

    private array $filtres;

    public function __construct()
    {
        $this->filtres = [
            new FiltreParNom(),
            new FiltreParType(),
        ];
    }

    public function getAllSalle(): array
    {
        return array_values($this->salles);
    }

    public function findSalle(int $id): ?Salle
    {
        return $this->salles[$id] ?? null;
    }

    public function saveSalle(Salle $salle): int
    {
        if (!$salle->getKey()) {
            $salle->setAttribute('id', count($this->salles) + 1);
        }
        $this->salles[(int) $salle->getKey()] = $salle;
        return (int) $salle->getKey();
    }

    public function rechercherEtPaginer(array $criteres, int $page, int $parPage): PaginationResult
    {
        $filtresActifs = array_filter($this->filtres, fn($f) => $f->estActif($criteres));

        $resultats = array_values(array_filter(
            $this->salles,
            function (Salle $s) use ($filtresActifs, $criteres) {
                foreach ($filtresActifs as $filtre) {
                    if (!$filtre->correspond($s, $criteres)) {
                        return false;
                    }
                }
                return true;
            }
        ));

        $total = count($resultats);
        $page = max(1, $page);
        $parPage = max(1, $parPage);
        $items = array_slice($resultats, ($page - 1) * $parPage, $parPage);

        return new PaginationResult($items, $total, $page, $parPage);
    }
}