<?php

namespace App\Database;

use App\Interfaces\DatabaseManagerInterface;
use PDO;
use PDOStatement;
use PDOException;

class DatabaseManager implements DatabaseManagerInterface
{
    private PDO $pdo;
    private PDOStatement $statement;
    private string $error = "";

    function __construct(string $host, string $dbName, string $user, string $password, int $port, ?string $charset = '')
    {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbName;options='--client_encoding=$charset'";
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function executeQuery(string $query, ?array $params = [], ?array $options = []): bool
    {
        $this->statement = $this->pdo->prepare($query);
        foreach ($params as $param) {
            $this->statement->bindParam($param->paramName, $param->value, $param->type);
        }

        try {
            if (!$this->statement->execute()) {
                $this->error = implode(":", $this->statement->errorInfo());
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }

        return empty($this->error);
    }

    public function fetch(?array $options = []): array|false
    {
        return $this->statement->fetch(PDO::FETCH_BOTH);
    }

    public function executeAndFetchOne(string $query, ?array $params = [], ?array $options = []): array|false
    {
        if ($this->executeQuery($query, $params, $options)) {
            return $this->fetch();
        }

        return [];
    }

    public function executeAndFetchAll(string $query, ?array $params = [], ?array $options = []): array|false
    {
        if ($this->executeQuery($query, $params, $options)) {
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }

    public function getLastError(): string
    {
        return $this->error ?: 'No error information available';
    }

    public function getRowCount(): int
    {
        return $this->statement->rowCount();
    }

    /**
     * @param string $host
     * @param string $dbName
     * @param string $user
     * @param string $password
     * @param int $port
     * @param string|null $charset
     * @return PDO
     */
    public function connect(string $host, string $dbName, string $user, string $password, int $port, ?string $charset = ''): PDO
    {
        // TODO: Implement connect() method.
    }
}
