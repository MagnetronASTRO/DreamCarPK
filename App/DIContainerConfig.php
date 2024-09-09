<?php

namespace App;

use App\Controllers\AdminController;
use App\Controllers\CarController;
use App\Controllers\ReservationController;
use App\Controllers\UserController;
use App\Interfaces\CarRepositoryInterface;
use App\Interfaces\ReservationRepositoryInterface;
use App\Repositories\CarRepository;
use App\Repositories\ReservationRepository;
use DI\ContainerBuilder;
use App\Database\DatabaseManager;
use App\Interfaces\DatabaseManagerInterface;
use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Controllers\AuthenticationController;
use App\Controllers\HomeController;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    DatabaseManagerInterface::class => function () {
        return new DatabaseManager(
            host: '172.20.0.10',
            dbName: 'dreamcarpk_local',
            user: 'dreamcarpk_local',
            password: 'dreamcarpk_local123!@#',
            port: '5432',
            charset: 'utf8'
        );
    },
    UserRepositoryInterface::class => \DI\autowire(UserRepository::class),
    CarRepositoryInterface::class => \DI\autowire(CarRepository::class),
    ReservationRepositoryInterface::class => \DI\autowire(ReservationRepository::class),
    UserController::class => \DI\autowire(UserController::class),
    AuthenticationController::class => \DI\autowire(AuthenticationController::class),
    HomeController::class => \DI\autowire(HomeController::class),
    CarController::class => \DI\autowire(CarController::class),
    ReservationController::class => \DI\autowire(ReservationController::class),
    AdminController::class => \DI\autowire(AdminController::class),
]);


return $containerBuilder->build();