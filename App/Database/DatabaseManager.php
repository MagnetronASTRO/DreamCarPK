<?php

namespace App\Database;

use App\Interfaces\DatabaseManagerInterface;
use PDO;
use PDOStatement;
use PDOException;

class DatabaseManager implements DatabaseManagerInterface
{
    private static ?DatabaseManager $instance = null;
    private static PDO $pdo;
    private static PDOStatement $statement;
    private static string $error = "";

    private function __construct(string $host, string $dbName, string $user, string $password, int $port, ?string $charset = '')
    {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbName;options='--client_encoding=$charset'";
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            self::$pdo = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getInstance(string $host = 'localhost', string $dbName = 'dreamcarpk', string $user = 'user', string $password = 'password', int $port = 5432, ?string $charset = 'utf8'): self
    {
        if (self::$instance === null) {
            self::$instance = new self($host, $dbName, $user, $password, $port, $charset);
        }
        return self::$instance;
    }

     // TODO: add logging database errors
//    private static function saveLog()
//    {
//        $query = 'INSERT INTO "database_log" VALUES()';
//    }

    public static function executeQuery(string $query, ?array $params = [], ?array $options = []): bool
    {
        if (count($params) > 0) {
            self::$statement = self::getInstance()::$pdo->prepare($query);

            foreach ($params as $param)
                self::$statement->bindParam($param->getName(), $param->getValue(), $param->getType());

            try {
                if (!self::$statement->execute())
                    self::$error = implode(":", self::$statement->errorInfo());
            } catch (PDOException $e) {
                self::$error = $e->getMessage();
            }
        } else {
            try {
                self::$statement = self::getInstance()::$pdo->query($query);
                if (!self::$statement)
                    self::$error = implode(":", self::$statement->errorInfo());
            } catch (PDOException $e) {
                self::$error = $e->getMessage();
            }
        }

//        if (!empty(self::$error)) {
//            self::saveLog();
//        }
        // TODO: add fetch mode, column etc
//        if (isset($options->fetchMode))
//            self::$statement->setFetchMode($options->fetchMode);

        return true;
    }

    public static function fetch(?array $options = []): array
    {
        return self::$statement->fetch();
    }

    public static function executeAndFetchOne(string $query, ?array $params = [], ?array $options = []): array
    {
        if (self::executeQuery($query, $params, $options))
            return self::fetch();

        return [];
    }

    public static function executeAndFetchAll(string $query, ?array $params = [], ?array $options = []): array
    {
        if (self::executeQuery($query, $params, $options))
            return self::$statement->fetchAll(PDO::FETCH_BOTH);

        return [];
    }

    public static function getLastError(): string
    {
        return self::$statement->errorInfo()[2] ?? 'No error information available';
    }

    public static function connect(string $host, string $dbName, string $user, string $password, int $port, ?string $charset = ''): PDO
    {
        $instance = self::getInstance($host, $dbName, $user, $password, $port, $charset);
        return $instance::$pdo;
    }

    public static function getRowCount(): int
    {
        return self::$statement->rowCount();
    }
}