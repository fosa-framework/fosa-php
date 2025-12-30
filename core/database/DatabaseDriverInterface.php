<?php

namespace Fosa\Core\Database;

use PDOStatement;

interface DatabaseDriverInterface
{
    public function connect(array $config, string $child): void;
    public function prepare(string $query): PDOStatement;
    public function query(string $query): PDOStatement;
    public function lastInsertId(): int;
    public function quote(string $string): string;
}
