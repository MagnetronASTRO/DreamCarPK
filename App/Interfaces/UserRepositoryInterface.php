<?php

namespace App\Interfaces;

interface UserRepositoryInterface {
    public function getAllUsers(): ?array;
    public function getUserById(int $id): ?array;
    public function getUserByUsername(string $username): ?array;
    public function createUser(array $data): bool;
    public function updateUser(int $id, array $data): bool;
    public function deleteUser(int $id): bool;
}