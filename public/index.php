<?php


use App\Application;
use DI\ContainerBuilder;

require dirname(__DIR__) . '/config/bootstrap.php';

$builder = new ContainerBuilder();
$builder->addDefinitions(
    dirname(__DIR__) . '/config/container.php'
);

$container = $builder->build();

$container->get(Illuminate\Database\Capsule\Manager::class);

$application = $container->get(Application::class);
$application->run();