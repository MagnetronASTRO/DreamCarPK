<?php

namespace App\APICalls;

//use App\Controllers\AuthenticationController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['type'])) {
    $container = require __DIR__ . '/../DIContainerConfig.php';
    $authenticationController = $container->get('App\Controllers\AuthenticationController');

//    call_user_func_array([$controllerInstance, $method], []);
    $result = false;

    switch($_POST['type']) {
        case 'signUp':
            $authenticationController->signUp();
            break;
        case 'signIn':
            $authenticationController->signIn();
            break;
    }
}