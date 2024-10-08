<?php

namespace App;

use App\Controllers\AdminController;
use App\Controllers\CarController;
use App\Controllers\ReservationController;
use App\Interfaces\AdminControllerInterface;
use App\Interfaces\AuthenticationControllerInterface;
use App\Interfaces\CarControllerInterface;
use App\Interfaces\CarRepositoryInterface;
use App\Interfaces\HomeControllerInterface;
use App\Interfaces\ReservationControllerInterface;
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
use function DI\autowire;

$containerBuilder = new ContainerBuilder();


$containerBuilder->addDefinitions([
    DatabaseManagerInterface::class => function () {
        $env = parse_ini_file(__DIR__ . '/../.env');
        return new DatabaseManager(
            host: '172.20.0.10',
            dbName: $env["DB_NAME"],
            user: $env["DB_USER"],
            password: $env["DB_PASSWORD"],
            port: '5432',
            charset: 'utf8'
        );
    },
    UserRepositoryInterface::class => autowire(UserRepository::class),
    CarRepositoryInterface::class => autowire(CarRepository::class),
    ReservationRepositoryInterface::class => autowire(ReservationRepository::class),
    AuthenticationControllerInterface::class => autowire(AuthenticationController::class),
    HomeControllerInterface::class => autowire(HomeController::class),
    CarControllerInterface::class => autowire(CarController::class),
    ReservationControllerInterface::class => autowire(ReservationController::class),
    AdminControllerInterface::class => autowire(AdminController::class),
]);


return $containerBuilder->build();