<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AdminController;
use App\Controllers\AuthenticationController;

$container = require __DIR__ . '/../App/DIContainerConfig.php';
$authenticationController = $container->get(AuthenticationController::class);
$adminController = $container->get(AdminController::class);

$response = ['success' => false, 'message' => 'Invalid fetch data!'];
error_log(print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action'])) {
    $response = match($_POST['action']) {
        'login' => $authenticationController->login($_POST['email'], $_POST['password']),
        'signUp' => $authenticationController->signUp($_POST['email'], $_POST['username'], $_POST['password']),
        'logout' => $authenticationController->logOut(),
        'addUser' => $adminController->addUser(),
        'showEditUser' => $adminController->showEditUser(),
        'editUserData' => $adminController->editUserData($_POST['userId'], $_POST['email'], $_POST['username'], $_POST['password']),
        'changeUserActivity' => $adminController->changeUserActivity(),
        'addCar' => $adminController->addCar($_POST['name'], $_POST['brand'], $_POST['model'], $_POST['year'], $_POST['color'], $_POST['price']),
        'editCar' => $adminController->editCar($_POST['carId'], $_POST['name'], $_POST['brand'], $_POST['model'], $_POST['year'], $_POST['color'], $_POST['price']),
        'deleteCar' => $adminController->deleteCar($_POST['carId']),

    };
}

echo json_encode($response);