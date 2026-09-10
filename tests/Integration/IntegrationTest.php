<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Reservation;
use App\Model\Salle;
use App\Repository\ReservationRepository;
use App\Repository\Filtre\Reservation\FiltreParSalle;
use App\Repository\Filtre\Reservation\FiltreParStatut;
use DateTimeImmutable;
use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase;

final class IntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        $capsule = new Capsule();
        $capsule->addConnection(['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        Capsule::schema()->create('salles', function ($table): void {
            $table->increments('id');
            $table->string('nom');
            $table->string('batiment')->nullable();
            $table->unsignedInteger('capacite');
            $table->boolean('active')->default(true);
            $table->unsignedInteger('type_salle_id')->nullable();
            $table->timestamps();
        });
        Capsule::schema()->create('reservations', function ($table): void {
            $table->increments('id');
            $table->unsignedInteger('salle_id');
            $table->unsignedInteger('statut_reservation_id')->default(1);
            $table->string('responsable');
            $table->string('email');
            $table->string('motif')->nullable();
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->timestamps();
        });
    }

    public function testCreationEtRelationSalleReservation(): void
    {
        $salle = Salle::create(['nom' => 'Salle A', 'batiment' => 'Bloc B', 'capacite' => 20, 'active' => true]);
        Reservation::create([
            'salle_id' => $salle->id,
            'responsable' => 'Jean',
            'email' => 'jean@example.com',
            'motif' => 'Cours',
            'date_debut' => '2030-01-01 10:00:00',
            'date_fin' => '2030-01-01 12:00:00',
        ]);

        $this->assertSame('Salle A', Salle::first()->nom);
        $this->assertCount(1, $salle->reservations);
    }

    public function testRechercheDeConflit(): void
    {
        $salle = Salle::create(['nom' => 'Salle B', 'batiment' => 'Bloc B', 'capacite' => 10, 'active' => true]);
        Reservation::create([
            'salle_id' => $salle->id,
            'responsable' => 'Alice',
            'email' => 'alice@example.com',
            'motif' => 'Cours',
            'date_debut' => '2030-01-01 10:00:00',
            'date_fin' => '2030-01-01 12:00:00',
        ]);

        $repository = new ReservationRepository([
        new FiltreParSalle(),
        new FiltreParStatut(),
]);
        $this->assertTrue($repository->chercherConflit($salle->id, new DateTimeImmutable('2030-01-01 11:00:00'), new DateTimeImmutable('2030-01-01 13:00:00')));
    }
}
