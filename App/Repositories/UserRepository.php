<?php

namespace App\Repositories;

use App\Database\bindParam;
use App\Interfaces\DatabaseManagerInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\UserModel;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private DatabaseManagerInterface $dbManager){}

    public function getAllUsers(): array
    {
        $users = [];
        $query = "SELECT *, user_role.role_id FROM \"user\"
                    LEFT JOIN \"user_role\" ON \"user\".id = \"user_role\".role_id";
        $this->dbManager->executeQuery($query);

        while ($row = $this->dbManager->fetch())
            $users[$row['id']] = new UserModel($row['id'], $row['username'], $row['email'], $row['role_id']);

        return $users;
    }

    public function getLastAddedUserId(): int|bool
    {
        $query = "SELECT id FROM \"user\" ORDER BY id DESC LIMIT 1";
        return $this->dbManager->executeQuery($query);
    }

    public function getUserById(int $id): UserModel|bool
    {
        $query = "SELECT * FROM \"user\" WHERE id = :userId";
        $params = [new bindParam(":userId", $id, 'i')];

        $result = $this->dbManager->executeAndFetchOne($query, $params);

        if ($result)
            return new UserModel($result['id'], $result['username'], $result['email'], $result['role_id']);

        return false;
    }

    public function getUserByUsername(string $username): UserModel|bool
    {
        $query = "SELECT * FROM \"user\" WHERE username = :username";
        $params = [new bindParam(":username", $username, 's')];

        $result = $this->dbManager->executeAndFetchOne($query, $params);

        if ($result)
            return new UserModel($result['id'], $result['username'], $result['email'], $result['role_id']);

        return false;
    }


    /**
     * @param string $email
     * @return object|bool
     */
    public function getUserByEmail(string $email): UserModel|bool
    {
        $query = "SELECT * FROM \"user\" WHERE email = :email";
        $params = [new bindParam(":email", $email, 's')];

        $result = $this->dbManager->executeAndFetchOne($query, $params);

        if ($result)
            return new UserModel($result['id'], $result['username'], $result['email'], $result['role_id']);

        return false;
    }

    public function addUserRole(int $userId, int $roleId): bool
    {
        $query = "INSERT INTO \"user_role\" VALUES (:userId, :roleId)";
        $params = [
            new bindParam(":userId", $userId, 'i'),
            new bindParam(":roleId", $roleId, 'i')
        ];

        return $this->dbManager->executeQuery($query, $params);
    }

    public function createUser(UserModel $newUser): bool
    {
        $query = "INSERT INTO \"user\" (username, password, email, created_at) VALUES (:username, :password, :email, NOW())";
        $params = [
            new bindParam(":username", $newUser->username, 's'),
            new bindParam(":password", $newUser->password, 's'),
            new bindParam(":email", $newUser->email, 's')
        ];

        if ($this->dbManager->executeQuery($query, $params)) {
            $userId = $this->getLastAddedUserId();
            return $this->addUserRole($userId, $newUser->role);
        }

        return false;
    }

    public function updateUser(int $id, UserModel $userData): bool
    {
        $query = "UPDATE \"user\" SET username = :username, password = :password, email = :email WHERE id = :userId";
        $params = [
            new bindParam(":username", $userData['username'], 's'),
            new bindParam(":password", $userData['password'], 's'),
            new bindParam(":email", $userData['email'], 's'),
            new bindParam(":userId", $id, 'i')
        ];
        return $this->dbManager->executeQuery($query, $params);
    }

    public function deleteUser(int $id): bool
    {
        $query = "DELETE FROM \"user\" WHERE id = :userId";
        $params = [new bindParam(":userId", $id, 'i')];
        return $this->dbManager->executeQuery($query, $params);
    }

    public function setUserToken(int $userId, string $token, int $expireTime): bool
    {
        $query = "UPDATE \"user\" SET token = :token, expire_time = :expireTime WHERE id = :userId";
        $params = [
            new bindParam(":token", $token, 's'),
            new bindParam(":expireTime", $expireTime, 'i'),
            new bindParam(":userId", $userId, 'i')
        ];
        return $this->dbManager->executeQuery($query, $params);
    }
}
