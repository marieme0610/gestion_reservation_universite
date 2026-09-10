<?php


use App\Application;
use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Repository\SalleRepository;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\Validation\ReservationValidator;
use App\Validation\SalleValidator;
use App\Repository\ReservationRepository;
use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;
use FastRoute\RouteCollector;
use Illuminate\Database\Capsule\Manager as Capsule;
use function DI\autowire;
use function DI\factory;
use App\Repository\Filtre\Reservation\FiltreParSalle;
use App\Repository\Filtre\Reservation\FiltreParStatut;
use App\Repository\Filtre\Salle\FiltreParNom;
use App\Repository\Filtre\Salle\FiltreParType;
use function DI\get;

return [

        'salle.filtres' => [
        autowire(FiltreParNom::class),
        autowire(FiltreParType::class),
    ],
    'reservation.filtres' => [
        autowire(FiltreParSalle::class),
        autowire(FiltreParStatut::class),
    ],

    SalleRepositoryInterface::class => autowire(SalleRepository::class)
        ->constructorParameter('filtres', get('salle.filtres')),
    ReservationRepositoryInterface::class => autowire(ReservationRepository::class)
        ->constructorParameter('filtres', get('reservation.filtres')),


    Capsule::class => factory(function (): Capsule {
        $capsule = new Capsule();

        $dbConfig = require dirname(__DIR__) . '/config/database.php';
        $capsule->addConnection($dbConfig);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    }),


    SalleValidator::class => autowire(),
    ReservationValidator::class => autowire(),

    CreerReservationService::class => autowire(),
    AnnulerReservationService::class => autowire(),


    SalleController::class => autowire(),
    ReservationController::class => autowire(),

    Dispatcher::class => factory(function (): Dispatcher {
        return simpleDispatcher(function (RouteCollector $r) {
            $routesDefinition = require dirname(__DIR__) . '/routes/web.php';
            $routesDefinition($r);
        });
    }),

    Application::class => autowire(),
];
