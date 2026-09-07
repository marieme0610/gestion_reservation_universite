<?php

namespace App;

use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;

final class Application
{
    public function __construct(
        private Dispatcher $dispatcher,
        private ContainerInterface $container
    ) {}

    public function run(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        try {
            $httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
            $uri = $_SERVER['REQUEST_URI'] ?? '/';

            if (false !== $pos = strpos($uri, '?')) {
                $uri = substr($uri, 0, $pos);
            }
            $uri = rawurldecode($uri);

            $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

            switch ($routeInfo[0]) {
                case Dispatcher::NOT_FOUND:
                    http_response_code(404);
                    require dirname(__DIR__) . '/templates/error/404.php';
                    break;

                case Dispatcher::METHOD_NOT_ALLOWED:
                    http_response_code(405);
                    header('Allow: ' . implode(', ', $routeInfo[1]));
                    require dirname(__DIR__) . '/templates/error/405.php';
                    break;

                case Dispatcher::FOUND:
                    [$controllerClass, $method] = $routeInfo[1];
                    $vars = $routeInfo[2];

                    $controller = $this->container->get($controllerClass);
                    $controller->$method(...array_values($vars));
                    break;
            }
        } catch (\Throwable $exception) {
            error_log((string) $exception);
            http_response_code(500);
            require dirname(__DIR__) . '/templates/error/500.php';
        }
    }
}
