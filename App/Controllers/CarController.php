<?php

namespace App\Controllers;

use App\Interfaces\CarRepositoryInterface;

class CarController
{
    public function __construct(private CarRepositoryInterface $carRepository) {}

    public function showCarPage(): void
    {
        $carId = filter_var($_POST['carId'], FILTER_SANITIZE_NUMBER_INT);
        $car = $this->carRepository->getCarById($carId);
        require_once __DIR__ . '/../Views/CarDetailsView.php';
    }
}
