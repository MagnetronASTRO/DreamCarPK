<?php

namespace App\Interfaces;

use App\Models\UserModel;

interface UserRepositoryInterface
{
    public function getAllUsers(): array;

    public function getLastAddedUserId(): int|bool;

    public function getUserById(int $id): UserModel|false;

    public function getUserByUsername(string $username): UserModel|false;

    public function getUserByEmail(string $email): UserModel|false;

    public function createUser(UserModel $newUser): int|bool;

    public function updateUser(int $userId, UserModel $userData): bool;

    public function deleteUser(int $userId): bool;

    public function setUserToken(int $userId, string $token, int $expireTime): bool;

    public function validateUserToken(string $token): bool;

    public function getUserToken(string $userToken): array|false;

    public function getUserRoles(int $userId): array;
}