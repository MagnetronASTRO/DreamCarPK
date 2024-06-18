<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthenticationController;

$container = require __DIR__ . '/../App/DIContainerConfig.php';
$AuthenticationController = $container->get(AuthenticationController::class);

$response = ['success' => false, 'message' => 'Invalid fetch data!'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action'])) {
    $response = match($_POST['action']) {
        'login' => $AuthenticationController->login($_POST['email'], $_POST['password']),
        'signUp' => $AuthenticationController->signUp($_POST['email'], $_POST['username'], $_POST['password']),
    };
}

echo json_encode($response);