<?php

namespace Core\Drivers;

class DriverFactory
{
    const DRIVER_MYSQL = 'mysql';

    /**
     * @param string $driver
     * @param string $user
     * @param string $pass
     * @param string $dbName
     * @param string $host Optional
     * @return MySQLDriver
     * @throws \Exception
     */
    public static function create(
        $driver,
        $user,
        $pass,
        $dbName,
        $host = null
    ) {
        switch ($driver) {
            case self::DRIVER_MYSQL:
                return new MySQLDriver($user, $pass, $dbName, $host);
            default:
                throw new \Exception("Invalid db driver");
        }
    }
}