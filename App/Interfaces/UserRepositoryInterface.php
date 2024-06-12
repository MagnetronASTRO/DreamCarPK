<?php

namespace App\Interfaces;

use App\Models\UserModel;

interface UserRepositoryInterface
{
    public function getAllUsers(): array;

    public function getLastAddedUserId(): int|bool;

    public function getUserById(int $id): UserModel|bool;

    public function getUserByUsername(string $username): UserModel|bool;

    public function getUserByEmail(string $email): UserModel|bool;

    public function createUser(UserModel $newUser): int|bool;

    public function updateUser(int $id, UserModel $userData): bool;

    public function deleteUser(int $id): bool;

    public function setUserToken(int $userId, string $token, int $expireTime): bool;
}