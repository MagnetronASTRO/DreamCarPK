<?php

namespace App\Controllers;

use App\Interfaces\CarRepositoryInterface;

class HomeController
{
    public function __construct(private CarRepositoryInterface $carRepository) {}

    public function showHomepage(): void
    {
        $cars = $this->carRepository->getAllCars();
        error_log(print_r($cars, true));
        require_once __DIR__ . '/../Views/HomeView.php';
    }
}
