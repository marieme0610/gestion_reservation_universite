<?php

declare(strict_types=1);

namespace Tests\Doubles;

use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;

final class InMemorySalleRepository implements SalleRepositoryInterface
{
    /** @var array<int, Salle> */
    private array $salles = [];

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
}
