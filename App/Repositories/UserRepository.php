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
            $users[$row['id']] = new UserModel($row['id'], $row['username'], $row['email'], $row['role_id'], is_active: $row['is_active']);

        return $users;
    }

    public function getLastAddedUserId(): int|bool
    {
        $query = "SELECT id FROM \"user\" ORDER BY id DESC LIMIT 1";
        return $this->dbManager->executeAndFetchOne($query)['id'];
    }

    public function getUserById(int $id): UserModel|false
    {
        $query = "SELECT * FROM \"user\"
                    LEFT JOIN \"user_role\" ON \"user\".id = \"user_role\".role_id
                    WHERE id = :userId";
        $params = [new bindParam(":userId", $id, 'i')];

        $result = $this->dbManager->executeAndFetchOne($query, $params);

        if ($result)
            return new UserModel($result['id'], $result['username'], $result['email'], $result['role_id'], $result['password'], is_active: $result['is_active']);

        return false;
    }

    public function getUserByUsername(string $username): UserModel|false
    {
        $query = "SELECT * FROM \"user\" 
                    LEFT JOIN \"user_role\" ON \"user\".id = \"user_role\".role_id
                     WHERE username = :username";
        $params = [new bindParam(":username", $username, 's')];

        $result = $this->dbManager->executeAndFetchOne($query, $params);

        if ($result)
            return new UserModel($result['id'], $result['username'], $result['email'], $result['role_id'], $result['password'], is_active: $result['is_active']);

        return false;
    }


    /**
     * @param string $email
     * @return object|bool
     */
    public function getUserByEmail(string $email): UserModel|false
    {
        $query = "SELECT *, \"user_role\".role_id FROM \"user\"
                    INNER JOIN \"user_role\" ON \"user\".id = \"user_role\".user_id
                    WHERE email = :email";
        $params = [new bindParam(":email", $email, 's')];

        $result = $this->dbManager->executeAndFetchOne($query, $params);

        if ($result)
            return new UserModel($result['id'], $result['username'], $result['email'], +$result['role_id'], $result['password'], is_active: $result['is_active']);

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
            new bindParam(":username", $newUser->username, 's_plain'),
            new bindParam(":password", $newUser->password, 's_plain'),
            new bindParam(":email", $newUser->email, 's')
        ];

        if ($this->dbManager->executeQuery($query, $params)) {
            $userId = $this->getLastAddedUserId();
            return $this->addUserRole((int)$userId, $newUser->role);
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
        $query = "INSERT INTO \"user_tokens\" (user_id, token, expiry) VALUES (:user_id, :token, :expiry)
                  ON CONFLICT (user_id) DO UPDATE SET token = :token, expiry = :expiry";
        $params = [
            new bindParam(":user_id", $userId, 'i'),
            new bindParam(":token", $token, 's'),
            new bindParam(":expiry", $expireTime, 'i')
        ];

        return $this->dbManager->executeQuery($query, $params);
    }

    /**
     * @param string $token
     * @return bool is user token valid
     */
    public function validateUserToken(string $token): bool
    {
        $query = "SELECT * FROM \"user_tokens\" WHERE token = :token AND expiry > :current_time";
        $params = [
            new bindParam(":token", $token, 's'),
            new bindParam(":current_time", time(), 'i')
        ];

        $result = $this->dbManager->executeAndFetchOne($query, $params);

        return !empty($result);
    }

    /**
     * @param int $userToken
     * @return string
     */
    public function getUserToken(string $userToken): array|false
    {
        $query = "SELECT * FROM \"user_tokens\" WHERE token = :token";
        $params = [new bindParam(":token", $userToken, 's')];

        return $this->dbManager->executeAndFetchOne($query, $params);
    }

    /**
     * @param int $userId
     * @return int role_id
     */
    public function getUserRole(int $userId): int
    {
        $query = "SELECT role_id FROM \"user_role\" WHERE user_id = :userId";
        $params = [new bindParam(":userId", $userId, 'i')];

        return $this->dbManager->executeAndFetchOne($query, $params)['role_id'] ?? 0;
    }

    /**
     * @param int $userId
     * @return array array of roles
     */
    public function getUserRoles(int $userId): array
    {
        $query = "SELECT r.role_name FROM \"role\" r
              INNER JOIN \"user_role\" ur ON r.id = ur.role_id
              WHERE ur.user_id = :userId";
        $params = [new bindParam(":userId", $userId, 'i')];

        return $this->dbManager->executeAndFetchAll($query, $params);
    }

    public function getRoles(): array
    {
        $query = "SELECT * FROM \"role\"";

        return $this->dbManager->executeAndFetchAll($query);
    }

    public function changeUserActivity(int $userId): bool
    {
        $user = $this->getUserById($userId);

        if (!$user)
            return false;

        $query = "UPDATE \"user\" SET is_active = :activity WHERE id = :userId";
        $params = [
            new bindParam(":userId", $user->id, 'i'),
            new bindParam(":activity", $user->is_active === 1 ? 0 : 1, 'i')
        ];

        return $this->dbManager->executeQuery($query, $params);
    }
}
