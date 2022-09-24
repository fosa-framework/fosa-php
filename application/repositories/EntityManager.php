<?php
    namespace Fosa\Application\Repositories;

    class EntityManager  {
        const SELECT = "SELECT";
        const INSERT = "INSERT";
        const UPDATE = "UPDATE";
        const DELETE = "DELETE";

        protected $database;
        protected $username;
        protected $password;
        protected $child;
        private $connection;

        private $query;

        public function __construct($database, $username, $password, $child = null) {
            $this->database = $database;
            $this->username = $username;
            $this->password = $password;
            $this->child = $child;
            try {
                $this->connection = new \PDO("mysql:host=localhost:3306;dbname={$this->database}", $this->username, $this->password);
                if(!$this->connection) {
                    die("Warning: Unable to connect to the database.");
                } else {
                    $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                }
            } catch(PDOException $e) {
                die($this->child . ' => ' . $e);
            }
        }

        protected function exec_get($query, $params = []) {
            try {
                if($this->connection) {
                    $request = null;
                    if($this->haveParams($params)) {
                        $query = $this->connection->prepare($query);
                        $query->execute($params);
                        $request = $query->fetchAll(\PDO::FETCH_ASSOC);
                    } else {
                        $request = $this->connection->query($query);
                    }
                    return $request;
                } else {
                    die();
                }
            } catch(Exception $e) {
                die($this->child . ' => ' . $e->getMessage());
            }
        }

        protected function haveParams($params) {
            return count($params) > 0 ? true : false;
        }

        protected function exec_post($sql, $params = []) {
            try {
                if($this->connection) {
                    $statement = $this->connection->prepare($sql);
                    $query_header = explode(' ', $sql)[0];
                    if($query_header === "INSERT") {
                        $statement->execute($params);
                        return $this->connection->lastInsertId();
                    }
                    return $statement->execute($params);
                } else {
                    die();
                }
            } catch(Exception $e) {
                die($this->child . ' => ' . $e->getMessage());
            }
        }

        protected function select($columns = "*")
        {
            $this->query = [self::SELECT];
            if(is_array($columns)) {
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
            if(is_array($params)) {
                $attributes = [];
                foreach ($params as $attribute => $value)
                {
                    array_push($attributes, $attribute);
                }
                array_push($this->query, '(' . join(', ', $attributes) . ')');
            }
            return $this;
        }

        protected function from($tables)
        {
            array_push($this->query, "FROM");
            if(is_array($tables)) {
                $entities = [];
                foreach ($tables as $table)
                {
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
            if(is_array($params)) {
                $params = self::sanitize($params);
                $values = [];
                foreach ($params as $value)
                {
                    array_push($values, $value);
                }
                array_push($this->query, '(' . join(', ', $values) . ')');
            }
            return $this;
        }

        protected function where($params = null)
        {
            if($params) {
                array_push($this->query, "WHERE");
                if(is_array($params)) {
                    $parameters = [];
                    foreach ($params as $param) {
                        if(is_string($param[1])) $param[1] = "'" . $param[1] . "'";
                        array_push($parameters, $param[0] . ' ' . $param[2] . ' ' .$param[1]);
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
            if($this->query) {
                switch (explode(' ', $this->query)[0]) {
                    case self::SELECT :
                        return $this->exec_get($this->query)->fetchAll();
                        break;
                    case self::UPDATE:
                    case self::DELETE:
                    case self::INSERT:
                        return $this->exec_post($this->query);
                        break;
                    default: die("Unsupported query type provided");
                    break;
                }
            } else {
                die("Any build query to run");
            }
        }

        protected function sanitize($array = []) {
            $result = [];
            foreach ($array as $key => $value) {
                $result[$key] = $this->connection->quote($value);
            }
            return $result;
        }

    }