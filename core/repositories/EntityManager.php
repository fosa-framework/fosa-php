<?php
namespace Fosa\Core\Repositories;

/**
 * Class EntityManager
 * This class is the base class for all the entity managers in the application.
 * 
 * @package Fosa\Core\Repositories
 */

use Fosa\Core\Database\DatabaseDriverInterface;
use PDO;

class EntityManager
{
    const SELECT = "SELECT";
    const INSERT = "INSERT";
    const UPDATE = "UPDATE";
    const DELETE = "DELETE";

    private DatabaseDriverInterface $database;

    private $query;

    public function __construct(DatabaseDriverInterface $database)
    {
        $this->database = $database;
    }

    protected function exec_get($query, $params = [])
    {
        if ($this->haveParams($params)) {
            $statement = $this->database->prepare($query);
            $statement->execute($params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return $this->database->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function haveParams($params)
    {
        return count($params) > 0 ? true : false;
    }

    protected function exec_post($sql, $params = [])
    {
        $statement = $this->database->prepare($sql);
        $query_header = explode(' ', $sql)[0];
        if ($query_header === "INSERT") {
            $statement->execute($params);
            return $this->database->lastInsertId();
        } else {
            return $statement->execute($params);
        }
    }

    protected function select($columns = "*")
    {
        $this->query = [self::SELECT];
        if (is_array($columns)) {
            $fields = [];
            foreach ($columns as $column) {
                array_push($fields, $column);
            }
            array_push($this->query, join(',', $fields));
        } else {
            array_push($this->query, $columns);
        }
        return $this;
    }

    protected function insert()
    {
        $this->query = [self::INSERT];
        return $this;
    }

    protected function into($table, $params)
    {
        array_push($this->query, "INTO");
        array_push($this->query, $table);
        if (is_array($params)) {
            $attributes = [];
            foreach ($params as $attribute => $value) {
                array_push($attributes, $attribute);
            }
            array_push($this->query, '(' . join(', ', $attributes) . ')');
        }
        return $this;
    }

    protected function from($tables)
    {
        array_push($this->query, "FROM");
        if (is_array($tables)) {
            $entities = [];
            foreach ($tables as $table) {
                array_push($entities, $table);
            }
            array_push($this->query, join(",", $entities));
        } else {
            array_push($this->query, $tables);
        }
        return $this;
    }

    protected function values($params)
    {
        array_push($this->query, "VALUES");
        if (is_array($params)) {
            $params = self::sanitize($params);
            $values = [];
            foreach ($params as $value) {
                array_push($values, $value);
            }
            array_push($this->query, '(' . join(', ', $values) . ')');
        }
        return $this;
    }

    protected function where($params = null)
    {
        if ($params) {
            array_push($this->query, "WHERE");
            if (is_array($params)) {
                $parameters = [];
                foreach ($params as $param) {
                    if (is_string($param[1])) $param[1] = "'" . $param[1] . "'";
                    array_push($parameters, $param[0] . ' ' . $param[2] . ' ' . $param[1]);
                }
                array_push($this->query, join(' AND ', $parameters));
            } else {
                array_push($this->query, $params);
            }
        }
        return $this;
    }

    protected function build()
    {
        $this->query = join(' ', $this->query) . ';';
        return $this;
    }

    protected function run()
    {
        if ($this->query) {
            switch (explode(' ', $this->query)[0]) {
                case self::SELECT:
                    return $this->exec_get($this->query);
                    break;
                case self::UPDATE:
                case self::DELETE:
                case self::INSERT:
                    return $this->exec_post($this->query);
                    break;
                default:
                    die("Unsupported query type provided");
                    break;
            }
        } else {
            die("Any build query to run");
        }
    }

    protected function sanitize($array = [])
    {
        $result = [];
        foreach ($array as $key => $value) {
            $result[$key] = $this->database->quote($value);
        }
        return $result;
    }
}
