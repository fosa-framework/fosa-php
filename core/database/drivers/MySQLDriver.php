<?php

namespace Fosa\Core\Database\Drivers;

use Fosa\Core\Database\DatabaseDriverInterface;
use PDO;
use PDOStatement;
use Exception;
use PDOException;

class MySQLDriver implements DatabaseDriverInterface
{
    private PDO $connection;
    protected $child;

    public function connect(array $config, string $child): void
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};port={$config['port']}";
        $this->child = $child;
        try {
            $this->connection = new PDO($dsn, $config['username'], $config['password']);
            if (!$this->connection) {
                throw new Exception("Warning: Unable to connect to the database.");
            } else {
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (PDOException $e) {
            die($this->child . ' => ' . $e);
        }
    }

    public function prepare(string $query): PDOStatement
    {
        return $this->connection->prepare($query);
    }

    public function query(string $sql): PDOStatement
    {
        return $this->connection->query($sql);
    }

    public function lastInsertId(): int
    {
        return $this->connection->lastInsertId();
    }

    public function quote(string $string): string
    {
        return $this->connection->quote($string);
    }
}
