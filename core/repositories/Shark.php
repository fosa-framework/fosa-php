<?php

namespace Fosa\Core\Repositories;

use Fosa\Core\Database\DatabaseFactory;

/**
 * Class Shark
 * This class is the base class for all the repositories in the application.
 * 
 * @package Fosa\Core\Repositories
 */

class Shark extends EntityManager
{
    const EQUAL = "=";
    const DIFFERENT = "!=";
    const MORE_THAN = ">";
    const LESS_THAN = "<";
    const MORE_THAN_OR_EQUAL = ">=";
    const LESS_THAN_OR_EQUAL = "<=";

    private $table;
    private $result;

    public function __construct($table)
    {
        $this->table = $table;
        $config = [
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
        ];
        $driver = DatabaseFactory::createConnection($config, 'Shark::' . $this->table);
        parent::__construct($driver);
    }

    protected function findAll()
    {
        $this->result = $this->select()->from($this->table)->where(1)->build()->run();
        return self::result();
    }

    protected function filter($columns, $params)
    {
        $this->result = $this->select($columns)->from($this->table)->where($params)->build()->run();
        return self::result();
    }

    protected function store($params)
    {
        $this->result = $this->insert()->into($this->table, $params)->values($params)->build()->run();
        return self::result();
    }

    protected function result()
    {
        return $this->result;
    }

    protected function first()
    {
        return is_array($this->result) && count($this->result) > 0 ? $this->result[0] : $this->result;
    }
}
