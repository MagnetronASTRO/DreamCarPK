<?php

use App\Database\DatabaseManager;
use App\DIContainer;
use App\Interfaces\DatabaseManagerInterface;

$container = new DIContainer;

//$databaseManager = new DatabaseManager(
//    '172.20.0.10',  // Static IP of the database server
//    'dreamcarpk_local',  // Database name
//    'dreamcarpk_local',  // Username
//    'dreamcarpk_local123!@#',  // Password
//    '5432',  // Port inside the container
//    'utf8'  // Charset
//);

// Bind the DatabaseManagerInterface to the instance of DatabaseManager
$container->get(DatabaseManager::class);

$GLOBALS['container'] = $container;
