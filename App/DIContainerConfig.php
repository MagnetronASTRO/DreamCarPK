<?php

use App\Controllers\UserController;
use DI\ContainerBuilder;
use App\Database\DatabaseManager;
use App\Interfaces\DatabaseManagerInterface;
use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;

$containerBuilder = new ContainerBuilder();

//$containerBuilder->addDefinitions([
//    DatabaseManagerInterface::class => DI\create(DatabaseManager::class)->constructor(
//        '172.20.0.10',
//        'dreamcarpk_local',
//        'dreamcarpk_local',
//        'dreamcarpk_local123!@#',
//        5432,
//        'utf8'
//    ),
//    UserRepositoryInterface::class => DI\autowire(UserRepository::class),
//]);

$containerBuilder->addDefinitions([
    DatabaseManager::class => function () {
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
    UserController::class => \DI\autowire(UserController::class),
]);


return $containerBuilder->build();