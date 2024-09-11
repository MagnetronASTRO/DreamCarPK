<?php

namespace App\Controllers;

use App\Interfaces\CarRepositoryInterface;
use App\Interfaces\HomeControllerInterface;

class HomeController implements HomeControllerInterface
{
    public function __construct(private CarRepositoryInterface $carRepository) {}

    public function showHomepage(): void
    {
        $cars = $this->carRepository->getAllCars();
        require_once __DIR__ . '/../Views/HomeView.php';
    }
}
