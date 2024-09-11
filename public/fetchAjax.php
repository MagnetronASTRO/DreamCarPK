<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AdminController;
use App\Controllers\AuthenticationController;
use App\Controllers\ReservationController;

$container = require __DIR__ . '/../App/DIContainerConfig.php';
$authenticationController = $container->get(AuthenticationController::class);
$adminController = $container->get(AdminController::class);
$reservationController = $container->get(ReservationController::class);

$response = ['success' => false, 'message' => 'Invalid fetch data!'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action'])) {
    $response = match($_POST['action']) {
        // login
        'login' => $authenticationController->login($_POST['username'], $_POST['password']),
        'logout' => $authenticationController->logOut(),
        // registration
        'signUp' => $authenticationController->signUp($_POST['email'], $_POST['username'], $_POST['password']),
        // user reservations
        'addReservation' => $reservationController->addReservation($_POST['carId'], $_POST['fromDate'], $_POST['returnDate']),
        // admin users
        'addUser' => $adminController->addUser(),
        'showEditUser' => $adminController->showEditUser(),
        'editUserData' => $adminController->editUserData($_POST['userId'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['role']),
        'changeUserActivity' => $adminController->changeUserActivity(),
        // admin cars
        'addCar' => $adminController->addCar($_POST['name'], $_POST['brand'], $_POST['model'], $_POST['year'], $_POST['color'], $_POST['price']),
        'editCar' => $adminController->editCar($_POST['carId'], $_POST['name'], $_POST['brand'], $_POST['model'], $_POST['year'], $_POST['color'], $_POST['price']),
        'deleteCar' => $adminController->deleteCar($_POST['carId']),
    };
}

echo json_encode($response);