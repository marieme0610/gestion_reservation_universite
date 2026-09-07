<?php

declare(strict_types=1);

namespace Tests\Doubles;

use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use DateTimeImmutable;

final class InMemoryReservationRepository implements ReservationRepositoryInterface
{
    /** @var array<int, Reservation> */
    private array $reservations = [];

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
}
