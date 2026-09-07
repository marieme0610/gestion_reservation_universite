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

return [

    SalleRepositoryInterface::class => autowire(SalleRepository::class),
    ReservationRepositoryInterface::class => autowire(ReservationRepository::class),


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
