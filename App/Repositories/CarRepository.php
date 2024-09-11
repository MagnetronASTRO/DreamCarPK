<?php

namespace App\Repositories;

use App\Database\bindParam;
use App\Interfaces\DatabaseManagerInterface;
use App\Interfaces\CarRepositoryInterface;
use App\Models\CarModel;

class CarRepository implements CarRepositoryInterface
{
    public function __construct(private DatabaseManagerInterface $dbManager) {}

    public function getAllCars(): array
    {
        $cars = [];
        $query = "
            SELECT c.id, c.make, c.model, c.year, c.is_available,
                   cp.photo_name,
                   cr.hour_price,
                   cs.power, cs.color
            FROM \"car\" c
            LEFT JOIN \"car_photo\" cp ON c.id = cp.car_id
            LEFT JOIN \"car_pricing\" cr ON c.id = cr.car_id
            LEFT JOIN \"car_spec\" cs ON c.id = cs.car_id
        ";
        $this->dbManager->executeQuery($query);

        while ($row = $this->dbManager->fetch()) {
            $carPricing = [
                'hour_price' => $row['hour_price']
            ];
            $carSpecs = [
                'power' => $row['power'],
                'color' => $row['color']
            ];

            $cars[] = new CarModel(
                $row['id'],
                $row['make'],
                $row['model'],
                $row['year'],
                $row['is_available'],
                $row['photo_name'],
                $carPricing,
                $carSpecs
            );
        }

        return $cars;
    }

    public function getCarById(int $id): CarModel|bool
    {
        $query = "
            SELECT c.id, c.make, c.model, c.year, c.is_available,
                   cp.photo_name,
                   cr.hour_price,
                   cs.power, cs.color
            FROM \"car\" c
            LEFT JOIN \"car_photo\" cp ON c.id = cp.car_id
            LEFT JOIN \"car_pricing\" cr ON c.id = cr.car_id
            LEFT JOIN \"car_spec\" cs ON c.id = cs.car_id
            WHERE c.id = :carId
        ";
        $params = [new bindParam(":carId", $id, 'i')];

        $result = $this->dbManager->executeAndFetchOne($query, $params);

        if ($result) {
            $carPricing = [
                'hour_price' => $result['hour_price'],
            ];
            $carSpecs = [
                'power' => $result['power'],
                'color' => $result['color']
            ];

            return new CarModel(
                $result['id'],
                $result['make'],
                $result['model'],
                $result['year'],
                $result['is_available'],
                $result['photo_name'],
                $carPricing,
                $carSpecs
            );
        }

        return false;
    }

    public function createCar(CarModel $newCar): bool
    {
        $query = "INSERT INTO \"car\" (make, model, year, is_available) VALUES (:make, :model, :year, :is_available)";
        $params = [
            new bindParam(":make", $newCar->getMaker(), 's'),
            new bindParam(":model", $newCar->getModel(), 's'),
            new bindParam(":year", $newCar->getYear(), 'i'),
            new bindParam(":is_available", $newCar->getIsAvailable(), 'b')
        ];

        return $this->dbManager->executeQuery($query, $params);
    }

    public function updateCar(int $id, CarModel $carData): bool
    {
        $query = "UPDATE \"car\" SET make = :make, model = :model, year = :year, is_available = :is_available WHERE id = :carId";
        $params = [
            new bindParam(":make", $carData->make, 's'),
            new bindParam(":model", $carData->model, 's'),
            new bindParam(":year", $carData->year, 'i'),
            new bindParam(":is_available", $carData->is_available, 'b'),
            new bindParam(":carId", $id, 'i')
        ];

        return $this->dbManager->executeQuery($query, $params);
    }

    public function deleteCar(int $id): bool
    {
        $query = "DELETE FROM \"car\" WHERE id = :carId";
        $params = [new bindParam(":carId", $id, 'i')];
        return $this->dbManager->executeQuery($query, $params);
    }
}
