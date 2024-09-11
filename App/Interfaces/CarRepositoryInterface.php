<?php

namespace App\Interfaces;
use App\Models\CarModel;

interface CarRepositoryInterface
{
    public function getAllCars(): array;
    public function getCarById(int $id): CarModel|bool;
    public function createCar(CarModel $newCar): bool;
    public function updateCar(int $id, CarModel $carData): bool;
    public function deleteCar(int $id): bool;
}
