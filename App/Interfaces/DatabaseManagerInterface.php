<?php

namespace App\Interfaces;

use PDO;

interface DatabaseManagerInterface
{
    public static function connect(string $host, string $dbName, string $user, string $password, int $port, ?string $charset = ''): PDO;

    public static function executeQuery(string $query, ?array $params = [], ?array $options = []): bool;

    public static function executeAndFetchOne(string $query, ?array $params = [], ?array $options = []): array;

    public static function executeAndFetchAll(string $query, ?array $params = [], ?array $options = []): array;

    public static function getRowCount(): int;

    public static function getLastError(): string;

    public static function fetch(?array $options = []): array;
}