<?php

namespace App\Database;

DatabaseManager::connect(
    '172.20.0.10',  // Static IP of the database server
    'dreamcarpk_local',  // Database name
    'dreamcarpk_local',        // Username
    'dreamcarpk_local123!@#',    // Password
    '5432',        // Port inside the container
    'utf8'         // Charset
);