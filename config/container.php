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
use function DI\autowire;
use function DI\factory;
use App\Repository\Filtre\Reservation\FiltreParSalle;
use App\Repository\Filtre\Reservation\FiltreParStatut;
use App\Repository\Filtre\Salle\FiltreParNom;
use App\Repository\Filtre\Salle\FiltreParType;
use function DI\get;
use App\Service\Regle\RegleSalleActive;
use App\Service\Regle\RegleOrdreDates;
use App\Service\Regle\RegleDureeMaximale;
use App\Service\Regle\RegleDateFuture;
use App\Service\Regle\RegleAbsenceDeConflit;
use App\Rendering\ResponseRendererInterface;
use App\Rendering\HtmlRenderer;
use App\Rendering\JsonRenderer;
use App\Service\SalleService;
use App\Service\ReservationQueryService;
use App\Core\SessionManager;
use App\Controller\AuthController;
use App\Service\AuthService;
use App\Repository\UtilisateurRepositoryInterface;
use App\Repository\UtilisateurRepository;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;

return [

    'salle.filtres' => [
    autowire(FiltreParNom::class),
    autowire(FiltreParType::class),
    ],
    'reservation.filtres' => [
        autowire(FiltreParSalle::class),
        autowire(FiltreParStatut::class),
    ],

        'middlewares.connecte' => [
        autowire(AuthMiddleware::class),
    ],
    'middlewares.admin' => [
        autowire(AuthMiddleware::class),
        autowire(AdminMiddleware::class),
    ],

    SalleRepositoryInterface::class => autowire(SalleRepository::class)
        ->constructorParameter('filtres', get('salle.filtres')),
    ReservationRepositoryInterface::class => autowire(ReservationRepository::class)
        ->constructorParameter('filtres', get('reservation.filtres')),

    SessionManager::class => autowire(),
    UtilisateurRepositoryInterface::class => autowire(UtilisateurRepository::class),
    AuthService::class => autowire(),
    AuthController::class => autowire(),

    SalleValidator::class => autowire(),
    ReservationValidator::class => autowire(),

    'reservation.regles' => [
        
    autowire(RegleSalleActive::class),
    autowire(RegleOrdreDates::class),
    autowire(RegleDureeMaximale::class),
    autowire(RegleDateFuture::class),
    autowire(RegleAbsenceDeConflit::class),
],

CreerReservationService::class => autowire()
    ->constructorParameter('regles', get('reservation.regles')),
    AnnulerReservationService::class => autowire(),

    SalleService::class => autowire(),
    ReservationQueryService::class => autowire(),

    SalleController::class => autowire(),
    ReservationController::class => autowire(),

    Dispatcher::class => factory(function (): Dispatcher {
        return simpleDispatcher(function (RouteCollector $r) {
            $routesDefinition = require dirname(__DIR__) . '/routes/web.php';
            $routesDefinition($r);
        });
    }),

        ResponseRendererInterface::class => factory(function (): ResponseRendererInterface {
        $mode = $_ENV['RENDER_MODE'] ?? 'html';

        return match ($mode) {
            'json'  => new JsonRenderer(),
            default => new HtmlRenderer(),
        };
    }),

    Application::class => autowire(),
];
