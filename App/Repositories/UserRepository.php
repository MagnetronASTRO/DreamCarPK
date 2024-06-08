<?php

namespace App\Repositories;

use App\Database\bindParam;
use App\Database\DatabaseManager;

class UserRepository
{
    public function __construct(private DatabaseManager $dbManager){}

    public function findById(int $id): ?array
    {
        $query = "SELECT * FROM \"user\" WHERE id = :userId";
        $params = [new bindParam(":userId", $id, 'i')];

        return $this->dbManager->executeAndFetchOne($query, $params);
    }

    public function findByUsername(string $username): ?array
    {
        $query = "SELECT * FROM \"user\" WHERE username = :username";
        $params = [new bindParam(":username", $username, "s")];

        return $this->dbManager->executeAndFetchOne($query, $params);
    }

    public function addUser(array $data): bool
    {
        $query = "INSERT INTO \"user\" (username, password, email) VALUES (:username, :password, :email)";
        $params = [
          new bindParam(":username", $data['username'], 's'),
          new bindParam(":password", $data['password'], 's'),
          new bindParam(":email", $data['email'], 's')
        ];

        return $this->dbManager->executeQuery($query, $params);
    }

    public function updateUserData(int $id, array $data): bool
    {
        $query = "UPDATE \"user\" SET username = :username, password = :password, email = :email WHERE id = :userId";
        $params = [
            new bindParam(":username", $data['username'], 's'),
            new bindParam(":password", $data['password'], 's'),
            new bindParam(":email", $data['email'], 's'),
            new bindParam(":userId", $id, 'i')
        ];
        return $this->dbManager->execute();
    }

    public function deleteUser(int $id): bool
    {
        $query = "DELETE FROM \"user\" WHERE id = :userId";
        $params = [new bindParam(":userId", $id, 'i')];

        return $this->dbManager->executeQuery($query, $params);
    }
}