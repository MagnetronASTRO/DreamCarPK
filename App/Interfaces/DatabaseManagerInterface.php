<?php

namespace App\Interfaces;

use PDO;

interface DatabaseManagerInterface
{
    public function connect(string $host, string $dbName, string $user, string $password, int $port, ?string $charset = ''): PDO;

    public function executeQuery(string $query, ?array $params = [], ?array $options = []): bool;

    public function executeAndFetchOne(string $query, ?array $params = [], ?array $options = []): array|false;

    public function executeAndFetchAll(string $query, ?array $params = [], ?array $options = []): array|false;

    public function getRowCount(): int;

    public function getLastError(): string;

    public function fetch(?array $options = []): array|false;
}