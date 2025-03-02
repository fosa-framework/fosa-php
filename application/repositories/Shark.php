<?php

namespace Fosa\Application\Repositories;

/**
 * Class Shark
 * This class is the base class for all the repositories in the application.
 * 
 * @package Fosa\Application\Repositories
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
        parent::__construct(getenv('DB_NAME'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), 'Shark::' . $this->table);
    }

    protected function findAll()
    {
        $this->result = $this->select()->from($this->table)->where(1)->build()->run();
        return $this;
    }

    protected function filter($columns, $params)
    {
        $this->result = $this->select($columns)->from($this->table)->where($params)->build()->run();
        return $this;
    }

    protected function store($params)
    {
        $this->result = $this->insert()->into($this->table, $params)->values($params)->build()->run();
        return $this;
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