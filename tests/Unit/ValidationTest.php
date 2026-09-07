<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Validation\ReservationValidator;
use App\Validation\SalleValidator;
use PHPUnit\Framework\TestCase;

final class ValidationTest extends TestCase
{
    private SalleValidator $salleValidator;
    private ReservationValidator $reservationValidator;

    protected function setUp(): void
    {
        $this->salleValidator = new SalleValidator();
        $this->reservationValidator = new ReservationValidator();
    }

    public function testAdresseElectroniqueInvalide(): void
    {
        $result = $this->reservationValidator->validate([
            'salle_id' => 1,
            'responsable' => 'Jean Dupont',
            'email' => 'email-invalide',
            'motif' => 'Cours universitaire',
            'date_debut' => '2030-01-01 10:00:00',
            'date_fin' => '2030-01-01 12:00:00',
        ]);
        $this->assertFalse($result->isValid());
        $this->assertTrue($result->hasError('email'));
    }

    public function testResponsableVide(): void
    {
        $result = $this->reservationValidator->validate([
            'salle_id' => 1,
            'responsable' => '',
            'email' => 'jean@example.com',
            'motif' => 'Cours universitaire',
            'date_debut' => '2030-01-01 10:00:00',
            'date_fin' => '2030-01-01 12:00:00',
        ]);
        $this->assertFalse($result->isValid());
        $this->assertTrue($result->hasError('responsable'));
    }

    public function testCapaciteNegative(): void
    {
        $result = $this->salleValidator->validate([
            'nom' => 'Salle A',
            'batiment' => 'Bloc B',
            'capacite' => -5,
            'active' => true,
            'type_salle_id' => 1,
        ]);
        $this->assertFalse($result->isValid());
        $this->assertTrue($result->hasError('capacite'));
    }

    public function testTypeSalleInconnu(): void
    {
        $result = $this->salleValidator->validate([
            'nom' => 'Salle A',
            'batiment' => 'Bloc B',
            'capacite' => 20,
            'active' => true,
            'type_salle_id' => 0,
        ]);
        $this->assertFalse($result->isValid());
        $this->assertTrue($result->hasError('type_salle_id'));
    }

    public function testDateIncorrecte(): void
    {
        $result = $this->reservationValidator->validate([
            'salle_id' => 1,
            'responsable' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'motif' => 'Cours universitaire',
            'date_debut' => '2026-13-45 25:99',
            'date_fin' => '2030-01-01 12:00:00',
        ]);
        $this->assertFalse($result->isValid());
        $this->assertTrue($result->hasError('date_debut'));
    }
}
