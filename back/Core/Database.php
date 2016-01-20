<?php

namespace Core;

use Core\Drivers\DriverFactory;
use PDO;
use PDOStatement;

class Database
{
    private static $inst = [];

    /**
     * @var \PDO
     */
    private $db;

    private function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $instanceName
     * @return Database
     * @throws \Exception
     */
    public static function getInstance($instanceName = 'default') {
        if (!isset(self::$inst[$instanceName])) {
            throw new \Exception('Instance with that name was not set');
        }

        return self::$inst[$instanceName];
    }

    public static function setInstance(
        $instanceName,
        $driver,
        $user,
        $pass,
        $dbName,
        $host = null
    ) {
        $driver = DriverFactory::create($driver, $user, $pass, $dbName, $host);

        $pdo = new \PDO(
            $driver->getDsn(),
            $user,
            $pass,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );

        self::$inst[$instanceName] = new self($pdo);
    }

    /**
     * @param string $statement
     * @param array $driverOptions
     * @return Statement
     */
    public function prepare($statement, array $driverOptions = [])
    {

        $statement = $this->db->prepare($statement, $driverOptions);

        return new Statement($statement);
    }

    public function query($query)
    {
        $this->db->query($query);
    }

    public function lastId($name = null)
    {
        return $this->db->lastInsertId($name);
    }

}

class Statement
{

    /**
     * @var \PDOStatement
     */
    private $stmt;

    public function __construct(\PDOStatement $statement)
    {
        $this->stmt = $statement;
    }

    /**
     * @param int $fetchStyle
     * @return mixed
     */
    public function fetch($fetchStyle = \PDO::FETCH_ASSOC)
    {
        return $this->stmt->fetch($fetchStyle);
    }

    public function fetchAll($fetchStyle = \PDO::FETCH_ASSOC)
    {
        return $this->stmt->fetchAll($fetchStyle);
    }

    public function bindParam($parameter, &$variable, $dataType = \PDO::PARAM_STR, $length = null, $driverOptions = null)
    {
        return $this->stmt->bindParam($parameter, $variable, $dataType, $length, $driverOptions);
    }

    /**
     * @param array|null $inputParameters
     * @return bool
     */
    public function execute(array $inputParameters = null)
    {

        return $this->stmt->execute($inputParameters);
    }

    /**
     * @return int
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function error()
    {
        return $this->stmt->errorInfo();
    }
}