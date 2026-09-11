<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Reservation;
use App\Model\Salle;
use App\Model\TypeSalle;
use App\Repository\ReservationRepository;
use App\Repository\SalleRepository;
use App\Repository\Filtre\Reservation\FiltreParSalle;
use App\Repository\Filtre\Reservation\FiltreParStatut;
use App\Repository\Filtre\Salle\FiltreParNom;
use App\Repository\Filtre\Salle\FiltreParType;
use App\Service\CreerReservationService;
use App\Service\Regle\RegleSalleActive;
use App\Service\Regle\RegleOrdreDates;
use App\Service\Regle\RegleDureeMaximale;
use App\Service\Regle\RegleDateFuture;
use App\Service\Regle\RegleAbsenceDeConflit;
use App\DTO\CreerReservationBuilder;
use App\Validation\ReservationValidator;
use App\Exception\SalleIndisponibleException;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Pagination\Paginator;
use PHPUnit\Framework\TestCase;

/**
 * Test d'intégration réel : plusieurs couches réelles ensemble
 * (Builder -> Validator -> DTO -> Service -> Règles métier -> Repository
 * -> vraie base de données SQLite en mémoire), pas une seule méthode
 * isolée comme un test unitaire.
 */
final class IntegrationTest extends TestCase
{
    private CreerReservationService $service;
    private ReservationRepository $reservationRepository;
    private SalleRepository $salleRepository;

    protected function setUp(): void
    {
        $capsule = new Capsule();
        $capsule->addConnection(['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        Paginator::currentPageResolver(fn () => 1);

        Capsule::schema()->create('type_salle', function ($table): void {
            $table->increments('id');
            $table->string('nom');
        });
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

        $this->reservationRepository = new ReservationRepository([
            new FiltreParSalle(),
            new FiltreParStatut(),
        ]);
        $this->salleRepository = new SalleRepository([
            new FiltreParNom(),
            new FiltreParType(),
        ]);
        $this->service = new CreerReservationService(
            $this->salleRepository,
            $this->reservationRepository,
            [
                new RegleSalleActive(),
                new RegleOrdreDates(),
                new RegleDureeMaximale(),
                new RegleDateFuture(),
                new RegleAbsenceDeConflit(),
            ]
        );
    }

    /**
     * Vérifie le cycle complet : Builder -> Validator -> DTO -> Service
     * (règles métier réelles) -> Repository -> vraie base de données,
     * puis relit la donnée pour confirmer qu'elle a bien été persistée.
     */
    public function testCycleCompletDeCreationDeReservation(): void
    {
        TypeSalle::create(['nom' => 'Amphithéâtre']);
        $salle = Salle::create([
            'nom' => 'Salle A', 'batiment' => 'Bloc B', 'capacite' => 20,
            'active' => true, 'type_salle_id' => 1,
        ]);

        $dto = CreerReservationBuilder::create()
            ->salleId($salle->id)
            ->responsable('Jean Dupont')
            ->email('jean@example.com')
            ->motif('Cours universitaire')
            ->dateDebut('2030-01-01 10:00:00')
            ->dateFin('2030-01-01 12:00:00')
            ->build(new ReservationValidator());

        $id = $this->service->creatReservation($dto);

        $reservationEnBase = $this->reservationRepository->findReservation($id);
        $this->assertNotNull($reservationEnBase);
        $this->assertSame('Jean Dupont', $reservationEnBase->responsable);
        $this->assertSame($salle->id, $reservationEnBase->salle_id);
    }

    /**
     * Vérifie que le cycle complet respecte bien les règles métier :
     * une deuxième réservation en conflit est rejetée par le VRAI Service,
     * avec la VRAIE détection de conflit en base — pas un double en mémoire.
     */
    public function testCycleCompletRejetteUnConflitReel(): void
    {
        TypeSalle::create(['nom' => 'Amphithéâtre']);
        $salle = Salle::create([
            'nom' => 'Salle B', 'batiment' => 'Bloc B', 'capacite' => 10,
            'active' => true, 'type_salle_id' => 1,
        ]);

        $validator = new ReservationValidator();

        $premiereDto = CreerReservationBuilder::create()
            ->salleId($salle->id)->responsable('Alice')->email('alice@example.com')
            ->motif('Cours')->dateDebut('2030-01-01 10:00:00')->dateFin('2030-01-01 12:00:00')
            ->build($validator);
        $this->service->creatReservation($premiereDto);

        $deuxiemeDto = CreerReservationBuilder::create()
            ->salleId($salle->id)->responsable('Bob')->email('bob@example.com')
            ->motif('Cours')->dateDebut('2030-01-01 11:00:00')->dateFin('2030-01-01 13:00:00')
            ->build($validator);

        $this->expectException(SalleIndisponibleException::class);
        $this->service->creatReservation($deuxiemeDto);
    }

    /**
     * Vérifie que la recherche paginée (Repository réel + Eloquent + filtres)
     * fonctionne ensemble, sur une vraie base.
     */
    public function testRechercheEtPaginationReelles(): void
    {
        TypeSalle::create(['nom' => 'Amphithéâtre']);
        $salleA = Salle::create(['nom' => 'Salle A', 'capacite' => 20, 'active' => true, 'type_salle_id' => 1]);
        $salleB = Salle::create(['nom' => 'Salle B', 'capacite' => 15, 'active' => true, 'type_salle_id' => 1]);

        Reservation::create([
            'salle_id' => $salleA->id, 'responsable' => 'X', 'email' => 'x@example.com',
            'motif' => 'Cours', 'date_debut' => '2030-01-01 10:00:00', 'date_fin' => '2030-01-01 12:00:00',
        ]);
        Reservation::create([
            'salle_id' => $salleB->id, 'responsable' => 'Y', 'email' => 'y@example.com',
            'motif' => 'Cours', 'date_debut' => '2030-01-02 10:00:00', 'date_fin' => '2030-01-02 12:00:00',
        ]);

        $resultat = $this->reservationRepository->rechercherEtPaginer(
            ['salle_id' => (string) $salleA->id],
            1,
            10
        );

        $this->assertSame(1, $resultat->total);
        $this->assertSame('X', $resultat->items[0]->responsable);
    }
}