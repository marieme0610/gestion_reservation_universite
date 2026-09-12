<?php

use FastRoute\RouteCollector;
use App\Controller\SalleController;
use App\Controller\ReservationController;
use App\Controller\AuthController;

return function (RouteCollector $r) {
    $r->addRoute('GET', '/health', [SalleController::class, 'healthCheck', 'public']);

    $r->addRoute('GET', '/login', [AuthController::class, 'showLogin', 'public']);
    $r->addRoute('POST', '/login', [AuthController::class, 'login', 'public']);
    $r->addRoute('POST', '/logout', [AuthController::class, 'logout', 'public']);

    $r->addRoute('GET', '/', [SalleController::class, 'index', 'connecte']);

    $r->addRoute('GET', '/salles', [SalleController::class, 'index', 'connecte']);
    $r->addRoute('GET', '/salles/create', [SalleController::class, 'create', 'admin']);
    $r->addRoute('POST', '/salles', [SalleController::class, 'store', 'admin']);
    $r->addRoute('GET', '/salles/{id:\d+}', [SalleController::class, 'show', 'connecte']);
    $r->addRoute('GET', '/salles/{id:\d+}/edit', [SalleController::class, 'edit', 'admin']);
    $r->addRoute('POST', '/salles/{id:\d+}/edit', [SalleController::class, 'update', 'admin']);

    $r->addRoute('GET', '/reservations', [ReservationController::class, 'index', 'connecte']);
    $r->addRoute('GET', '/reservations/create', [ReservationController::class, 'create', 'connecte']);
    $r->addRoute('POST', '/reservations', [ReservationController::class, 'store', 'connecte']);
    $r->addRoute('GET', '/reservations/{id:\d+}', [ReservationController::class, 'show', 'connecte']);
    $r->addRoute('POST', '/reservations/{id:\d+}/cancel', [ReservationController::class, 'cancel', 'connecte']);

};