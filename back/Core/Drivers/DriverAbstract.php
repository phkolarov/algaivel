<?php

namespace Core\Drivers;

abstract class DriverAbstract
{
    protected $user;
    protected $pass;
    protected $dbName;
    protected $host;

    public function __construct($user, $pass, $dbName, $host = null)
    {
        $this->user = $user;
        $this->pass = $pass;
        $this->dbName = $dbName;
        $this->host = $host;
    }

    /**
     * @return string
     */
    public abstract function getDsn();
}