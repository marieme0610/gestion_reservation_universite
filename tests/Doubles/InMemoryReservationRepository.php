<?php

declare(strict_types=1);

namespace Tests\Doubles;

use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\Filtre\Reservation\FiltreParSalle;
use App\Repository\Filtre\Reservation\FiltreParStatut;
use App\Support\PaginationResult;
use DateTimeImmutable;

final class InMemoryReservationRepository implements ReservationRepositoryInterface
{
    /** @var array<int, Reservation> */
    private array $reservations = [];

    private array $filtres;

    public function __construct()
    {

        $this->filtres = [
            new FiltreParSalle(),
            new FiltreParStatut(),
        ];
    }

    public function getAllReservation(): array
    {
        return array_values($this->reservations);
    }

    public function findReservation(int $id): ?Reservation
    {
        return $this->reservations[$id] ?? null;
    }

    public function saveReservation(Reservation $reservation): int
    {
        if (!$reservation->getKey()) {
            $reservation->setAttribute('id', count($this->reservations) + 1);
        }
        $this->reservations[(int) $reservation->getKey()] = $reservation;
        return (int) $reservation->getKey();
    }

    public function annulerReservation(int $id): bool
    {
        $reservation = $this->findReservation($id);
        if (!$reservation) return false;
        $reservation->statut_reservation_id = 2;
        return true;
    }

    public function chercherConflit(int $salleId, DateTimeImmutable $debut, DateTimeImmutable $fin): bool
    {
        foreach ($this->reservations as $reservation) {
            if ((int) $reservation->salle_id !== $salleId || (int) $reservation->statut_reservation_id === 2) continue;
            $existingStart = new DateTimeImmutable((string) $reservation->date_debut);
            $existingEnd = new DateTimeImmutable((string) $reservation->date_fin);
            if ($debut < $existingEnd && $fin > $existingStart) return true;
        }
        return false;
    }

    public function rechercherEtPaginer(array $criteres, int $page, int $parPage): PaginationResult
    {
        $filtresActifs = array_filter($this->filtres, fn($f) => $f->estActif($criteres));

        $resultats = array_values(array_filter(
            $this->reservations,
            function (Reservation $r) use ($filtresActifs, $criteres) {
                foreach ($filtresActifs as $filtre) {
                    if (!$filtre->correspond($r, $criteres)) {
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