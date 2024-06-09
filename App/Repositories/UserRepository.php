<?php

namespace App\Repositories;

use App\Database\bindParam;
use App\Database\DatabaseManager;
use App\Interfaces\DatabaseManagerInterface;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private DatabaseManager $dbManager){}

    public function getAllUsers(): array
    {
        $query = "SELECT * FROM \"user\"";
        return $this->dbManager::executeAndFetchAll($query);
    }

    public function getUserById(int $id): ?array
    {
        $query = "SELECT * FROM \"user\" WHERE id = :userId";
        $params = [new bindParam(":userId", $id, 'i')];
        return $this->dbManager::executeAndFetchOne($query, $params);
    }

    public function getUserByUsername(string $username): ?array
    {
        $query = "SELECT * FROM \"user\" WHERE username = :username";
        $params = [new bindParam(":username", $username, 's')];
        return $this->dbManager::executeAndFetchOne($query, $params);
    }

    public function createUser(array $data): bool
    {
        $query = "INSERT INTO \"user\" (username, password, email) VALUES (:username, :password, :email)";
        $params = [
            new bindParam(":username", $data['username'], 's'),
            new bindParam(":password", $data['password'], 's'),
            new bindParam(":email", $data['email'], 's')
        ];

        return $this->dbManager::executeQuery($query, $params);
    }

    public function updateUser(int $id, array $data): bool
    {
        $query = "UPDATE \"user\" SET username = :username, password = :password, email = :email WHERE id = :userId";
        $params = [
            new bindParam(":username", $data['username'], 's'),
            new bindParam(":password", $data['password'], 's'),
            new bindParam(":email", $data['email'], 's'),
            new bindParam(":userId", $id, 'i')
        ];
        return $this->dbManager::executeQuery($query, $params);
    }

    public function deleteUser(int $id): bool
    {
        $query = "DELETE FROM \"user\" WHERE id = :userId";
        $params = [new bindParam(":userId", $id, 'i')];
        return $this->dbManager::executeQuery($query, $params);
    }
}
