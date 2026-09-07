<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Salle;
use App\Service\CreerReservationService;
use App\Validation\ReservationValidator;
use DateTimeImmutable;
use Exception;
use PHPUnit\Framework\TestCase;
use Tests\Doubles\InMemoryReservationRepository;
use Tests\Doubles\InMemorySalleRepository;

final class CreerReservationServiceTest extends TestCase
{
    private InMemorySalleRepository $salles;
    private InMemoryReservationRepository $reservations;
    private CreerReservationService $service;

    protected function setUp(): void
    {
        $this->salles = new InMemorySalleRepository();
        $this->reservations = new InMemoryReservationRepository();
        $this->service = new CreerReservationService($this->salles, $this->reservations);
    }

    private function dto(string $debut, string $fin): CreerReservationDTO
    {
        return CreerReservationDTO::fromArray(new ReservationValidator(), [
            'salle_id' => 1,
            'responsable' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'motif' => 'Cours universitaire',
            'date_debut' => $debut,
            'date_fin' => $fin,
        ]);
    }

    private function salle(bool $active = true): void
    {
        $salle = new Salle(['nom' => 'Salle A', 'capacite' => 20, 'active' => $active, 'type_salle_id' => 1]);
        $salle->setAttribute('id', 1);
        $this->salles->saveSalle($salle);
    }

    public function testReservationValide(): void
    {
        $this->salle();
        $id = $this->service->creatReservation($this->dto('2030-01-01 10:00:00', '2030-01-01 12:00:00'));
        $this->assertSame(1, $id);
    }

    public function testSalleInexistante(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Salle introuvable.');
        $this->service->creatReservation($this->dto('2030-01-01 10:00:00', '2030-01-01 12:00:00'));
    }

    public function testSalleInactive(): void
    {
        $this->salle(false);
        $this->expectException(SalleIndisponibleException::class);
        $this->service->creatReservation($this->dto('2030-01-01 10:00:00', '2030-01-01 12:00:00'));
    }

    public function testFinAvantDebut(): void
    {
        $this->salle();
        $this->expectException(Exception::class);
        $this->service->creatReservation($this->dto('2030-01-01 12:00:00', '2030-01-01 10:00:00'));
    }

    public function testDureeSuperieureAQuatreHeures(): void
    {
        $this->salle();
        $this->expectException(Exception::class);
        $this->service->creatReservation($this->dto('2030-01-01 10:00:00', '2030-01-01 15:00:00'));
    }

    public function testConflitDeCreneau(): void
    {
        $this->salle();
        $this->service->creatReservation($this->dto('2030-01-01 10:00:00', '2030-01-01 12:00:00'));
        $this->expectException(SalleIndisponibleException::class);
        $this->service->creatReservation($this->dto('2030-01-01 11:00:00', '2030-01-01 13:00:00'));
    }
}
