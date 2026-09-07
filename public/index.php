<?php

use App\Router\Router;

$container = require_once __DIR__ . '/../config/bootstrap.php';

$routesPath   = __DIR__ . '/../routes/web.php';
$error404Path = __DIR__ . '/../templates/error/404.php';
$error405Path = __DIR__ . '/../templates/error/405.php';

$router = new Router($container, $routesPath, $error404Path, $error405Path);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

