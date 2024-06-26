<?php

namespace App\APICalls;

//use App\Controllers\AuthenticationController;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['type'])) {
    $container = require __dir__ . '/../dicontainerconfig.php';
    $authenticationController = $container->get('app\controllers\authenticationcontroller');

//    call_user_func_array([$controllerinstance, $method], []);
    $result = false;

    switch($_post['type']) {
        case 'signup':
            $authenticationController->signup();
            break;
        case 'signin':
            $authenticationController->signin();
            break;
    }
}