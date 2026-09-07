<?php

namespace App\Router;

use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;
use Psr\Container\ContainerInterface;

class Router
{
    private ?ContainerInterface $container;
    private string $routesPath;
    private string $error404Path;
    private string $error405Path;

    public function __construct(
        ?ContainerInterface $container,
        string $routesPath,
        string $error404Path,
        string $error405Path
    ) {
        $this->container = $container;
        $this->routesPath = $routesPath;
        $this->error404Path = $error404Path;
        $this->error405Path = $error405Path;
    }

    public function dispatch(string $httpMethod, string $uri): void
    {
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routesDefinition = require $this->routesPath;
        $dispatcher = simpleDispatcher($routesDefinition);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                require $this->error404Path;
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                http_response_code(405);
                header('Allow: ' . implode(', ', $allowedMethods));
                require $this->error405Path;
                break;

            case Dispatcher::FOUND:
                [$controllerClass, $method] = $routeInfo[1];
                $vars = $routeInfo[2];

                $controller = $this->container 
                    ? $this->container->get($controllerClass) 
                    : new $controllerClass();

                call_user_func_array([$controller, $method], array_values($vars));
                break;
        }
    }
}