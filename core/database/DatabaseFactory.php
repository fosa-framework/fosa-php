<?php

namespace Fosa\Core\Database;

use Fosa\Core\Database\Drivers\MySQLDriver;

class DatabaseFactory
{
    public static function createConnection(array $config, string $child): DatabaseDriverInterface
    {
        switch ($config['driver']) {
            case 'mysql':
                return self::build(new MySQLDriver(), $config, $child);
            default:
                throw new \Exception("Unsupported database driver: " . $config['driver']);
        }
    }

    public static function build(DatabaseDriverInterface $driver, array $config, string $child): DatabaseDriverInterface
    {
        $driver->connect($config, $child);
        return $driver;
    }
}
