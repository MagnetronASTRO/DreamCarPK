<?php

namespace App\Repositories;

use App\Database\bindParam;
use App\Interfaces\DatabaseManagerInterface;
use App\Interfaces\ReservationRepositoryInterface;
use App\Models\CarModel;
use App\Models\ReservationModel;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function __construct(private DatabaseManagerInterface $dbManager) {}

    public function getAllReservations(): array
    {
        $reservations = [];
        $query = "SELECT *, \"car\".make, \"car\".model, \"car\".year
                    FROM \"reservation\" r
                    LEFT JOIN \"car\" ON \"car\".id = r.car_id";
        $this->dbManager->executeQuery($query);

        while ($row = $this->dbManager->fetch())
            $reservations[$row['id']] = new ReservationModel(
                id: $row['id'],
                userId: $row['user_id'],
                car: new CarModel($result['car_id'], $result['make'], $result['model'], $result['year'], 0),
                fromDate: $row['reservation_date'],
                returnDate: $row['return_date'],
                isActive: $row['return_date'] > date("Y-m-d") ? 0 : 1
            );

        return $reservations;
    }

    public function getLastAddedReservation(): ReservationModel|false
    {
        $query = "SELECT *, \"car\".make, \"car\".model, \"car\".year
                    FROM \"reservation\" r
                    LEFT JOIN \"car\" ON \"car\".id = r.car_id
                    ORDER BY r.id DESC LIMIT 1";
        $this->dbManager->executeQuery($query);

        $result = $this->dbManager->executeAndFetchOne($query);

        if ($result) {
            return new ReservationModel(
                id: $result['id'],
                userId: $result['user_id'],
                car: new CarModel($result['car_id'], $result['make'], $result['model'], $result['year'], 0),
                fromDate: $result['reservation_date'],
                returnDate: $result['return_date'],
                isActive: $result['return_date'] > date("Y-m-d") ? 0 : 1
            );
        }

        return false;
    }

    public function getReservationById(int $reservationId): ReservationModel|false
    {
        $query = "SELECT *, \"car\".make, \"car\".model, \"car\".year
                    FROM \"reservation\" r 
                    LEFT JOIN \"car\" ON \"car\".id = r.car_id 
                    WHERE r.id = :reservationId ORDER BY r.id DESC LIMIT 1";
        $params = [new bindParam(":reservationId", $reservationId, 'i')];

        $result = $this->dbManager->executeAndFetchOne($query, $params);

        if ($result) {
            return new ReservationModel(
                id: $result['id'],
                userId: $result['user_id'],
                car: new CarModel($result['car_id'], $result['make'], $result['model'], $result['year'], 0),
                fromDate: $result['reservation_date'],
                returnDate: $result['return_date'],
                isActive: $result['return_date'] > date("Y-m-d") ? 0 : 1
            );
        }

        return false;
    }

    public function getUserReservations(string $userId): array
    {
        $reservations = [];
        $query = "SELECT *, \"car\".make, \"car\".model, \"car\".year 
                    FROM \"reservation\" r 
                    LEFT JOIN \"car\" ON \"car\".id = r.car_id
                    WHERE user_id = :userId 
                    ORDER BY r.id DESC";
        $params = [new bindParam(":userId", $userId, 'i')];

        $this->dbManager->executeQuery($query, $params);

        while ($row = $this->dbManager->fetch())
            $reservations[$row['id']] = new ReservationModel(
                id: $row['id'],
                userId: $row['user_id'],
                car: new CarModel($row['car_id'], $row['make'], $row['model'], $row['year'], 0),
                fromDate: $row['reservation_date'],
                returnDate: $row['return_date'],
                isActive: $row['return_date'] > date("Y-m-d") ? 0 : 1
            );

        return $reservations;
    }
}