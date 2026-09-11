<?php

use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Repository\SalleRepository;
use App\Service\CreerReservationService;
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
use App\Repository\UtilisateurRepositoryInterface;
use App\Repository\UtilisateurRepository;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;
use App\Validation\SalleValidatorInterface;
use App\Validation\SalleValidator;
use App\Validation\ReservationValidatorInterface;
use App\Validation\ReservationValidator;
use App\Service\AnnulerReservationServiceInterface;
use App\Service\AnnulerReservationService;
use App\Rendering\RenderModeResolver;
use App\Middleware\RenderModeMiddleware;
use Psr\Container\ContainerInterface;


return [

    'salle.filtres' => [
        autowire(FiltreParNom::class),
        autowire(FiltreParType::class),
    ],
    'reservation.filtres' => [
        autowire(FiltreParSalle::class),
        autowire(FiltreParStatut::class),
    ],

       'middlewares.public' => [
        autowire(RenderModeMiddleware::class),
    ],
    'middlewares.connecte' => [
        autowire(RenderModeMiddleware::class),
        autowire(AuthMiddleware::class),
    ],
    'middlewares.admin' => [
        autowire(RenderModeMiddleware::class),
        autowire(AuthMiddleware::class),
        autowire(AdminMiddleware::class),
    ],

    'reservation.regles' => [
        autowire(RegleSalleActive::class),
        autowire(RegleOrdreDates::class),
        autowire(RegleDureeMaximale::class),
        autowire(RegleDateFuture::class),
        autowire(RegleAbsenceDeConflit::class),
    ],

    SalleRepositoryInterface::class => autowire(SalleRepository::class)
        ->constructorParameter('filtres', get('salle.filtres')),
    ReservationRepositoryInterface::class => autowire(ReservationRepository::class)
        ->constructorParameter('filtres', get('reservation.filtres')),
    UtilisateurRepositoryInterface::class => autowire(UtilisateurRepository::class),

    SalleValidatorInterface::class => autowire(SalleValidator::class),
    ReservationValidatorInterface::class => autowire(ReservationValidator::class),

        AnnulerReservationServiceInterface::class => autowire(AnnulerReservationService::class),

    CreerReservationService::class => autowire()
        ->constructorParameter('regles', get('reservation.regles')),

    Dispatcher::class => factory(function (): Dispatcher {
        return simpleDispatcher(function (RouteCollector $r) {
            $routesDefinition = require dirname(__DIR__) . '/routes/web.php';
            $routesDefinition($r);
        });
    }),

       ResponseRendererInterface::class => factory(function (ContainerInterface $c): ResponseRendererInterface {
        $mode = $c->get(RenderModeResolver::class)->getMode();

        return match ($mode) {
            'json'  => new JsonRenderer(),
            default => new HtmlRenderer(),
        };
    }),

];