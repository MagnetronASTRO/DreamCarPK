<?php

namespace App\Interfaces;

interface UserRepositoryInterface {
    public function findById(int $id): ?array;
    public function findByUsername(string $username): ?array;
    public function create(array $data): bool;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}