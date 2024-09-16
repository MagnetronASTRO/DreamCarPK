<?php

namespace Tests;

use DI\ContainerBuilder;
use App\Interfaces\AuthenticationControllerInterface;
use App\Controllers\AuthenticationController;
use App\Interfaces\HomeControllerInterface;
use App\Controllers\HomeController;
use App\Interfaces\CarRepositoryInterface;
use App\Repositories\CarRepository;
use App\Interfaces\DatabaseManagerInterface;
//use App\Database\DatabaseManager;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    DatabaseManagerInterface::class => function () {
        // Return a mock DatabaseManager for testing purposes
        return $this->createMock(DatabaseManagerInterface::class);
    },
    AuthenticationControllerInterface::class => \DI\autowire(AuthenticationController::class),
    HomeControllerInterface::class => \DI\autowire(HomeController::class),
    CarRepositoryInterface::class => \DI\autowire(CarRepository::class),
]);

return $containerBuilder->build();
