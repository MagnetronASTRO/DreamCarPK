<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    private $queryExecutor;

    public function __construct(DatabaseQueryExecutor $queryExecutor) {
        $this->queryExecutor = $queryExecutor;
    }

    public function findById(int $id): ?array {
        $query = 'SELECT * FROM users WHERE id = ?';
        return $this->queryExecutor->selectOne($query, [$id]);
    }

    public function findByUsername(string $username): ?array {
        $query = 'SELECT * FROM users WHERE username = ?';
        return $this->queryExecutor->selectOne($query, [$username]);
    }

    public function add(array $data): bool {
        $query = 'INSERT INTO users (username, password, email) VALUES (?, ?, ?)';
        return $this->queryExecutor->insert($query, [
            $data['username'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['email']
        ]);
    }

    public function update(int $id, array $data): bool {
        $query = 'UPDATE users SET username = ?, password = ?, email = ? WHERE id = ?';
        return $this->queryExecutor->update($query, [
            $data['username'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['email'],
            $id
        ]);
    }

    public function delete(int $id): bool {
        $query = 'DELETE FROM users WHERE id = ?';
        return $this->queryExecutor->delete($query, [$id]);
    }
}