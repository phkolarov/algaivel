<?php
namespace Repositories;

use Core\Database;
use Models\User;
use Collections\UserCollection;

class UserRepository
{
    private $query;
    private $where = " WHERE 1";
    private $placeholders = [];
    private $order = '';
    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];
    /**
     * @var UserRepository
     */
    private static $inst = null;
    private function __construct() { }
    /**
     * @return UserRepository
     */
    public static function create()
    {
        if (self::$inst == null) {
        }
        self::$inst = new self();
        return self::$inst;
    }
    /**
     * @param $id
     * @return $this
     */
    public function filterById($id)
    {
        $this->where .= " AND id = ?";
        $this->placeholders[] = $id;
        return $this;
    }    /**
     * @param $username
     * @return $this
     */
    public function filterByUsername($username)
    {
        $this->where .= " AND username = ?";
        $this->placeholders[] = $username;
        return $this;
    }    /**
     * @param $password
     * @return $this
     */
    public function filterByPassword($password)
    {
        $this->where .= " AND password = ?";
        $this->placeholders[] = $password;
        return $this;
    }    /**
     * @param $registerDate
     * @return $this
     */
    public function filterByRegisterDate($registerDate)
    {
        $this->where .= " AND registerDate = ?";
        $this->placeholders[] = $registerDate;
        return $this;
    }    /**
     * @param $emailVerified
     * @return $this
     */
    public function filterByEmailVerified($emailVerified)
    {
        $this->where .= " AND emailVerified = ?";
        $this->placeholders[] = $emailVerified;
        return $this;
    }    /**
     * @param $email
     * @return $this
     */
    public function filterByEmail($email)
    {
        $this->where .= " AND email = ?";
        $this->placeholders[] = $email;
        return $this;
    }    /**
     * @param $createdAt
     * @return $this
     */
    public function filterByCreatedAt($createdAt)
    {
        $this->where .= " AND createdAt = ?";
        $this->placeholders[] = $createdAt;
        return $this;
    }    /**
     * @param $updatedAt
     * @return $this
     */
    public function filterByUpdatedAt($updatedAt)
    {
        $this->where .= " AND updatedAt = ?";
        $this->placeholders[] = $updatedAt;
        return $this;
    }
    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function orderBy($column)
    {
        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }
        if (!empty($this->order)) {
            throw new \Exception("Cannot do primary order, because you already have a primary order");
        }
        $this->order .= " ORDER BY $column";
        return $this;
    }
    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function orderByDescending($column)
    {
        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }
        if (!empty($this->order)) {
            throw new \Exception("Cannot do primary order, because you already have a primary order");
        }
        $this->order .= " ORDER BY $column DESC";
        return $this;
    }
    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function thenBy($column)
    {
        if (empty($this->order)) {
            throw new \Exception("Cannot do secondary order, because you don't have a primary order");
        }
        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }
        $this->order .= ", $column ASC";
        return $this;
    }
    /**
     * @param $column
     * @return $this
     * @throws \Exception
     */
    public function thenByDescending($column)
    {
        if (empty($this->order)) {
            throw new \Exception("Cannot do secondary order, because you don't have a primary order");
        }
        if (!$this->isColumnAllowed($column)) {
            throw new \Exception("Column not found");
        }
        $this->order .= ", $column DESC";
        return $this;
    }
    /**
     * @return UserCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM user" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new User($entityInfo['username'],
$entityInfo['password'],
$entityInfo['registerDate'],
$entityInfo['emailVerified'],
$entityInfo['email'],
$entityInfo['createdAt'],
$entityInfo['updatedAt'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new UserCollection($collection);
    }
    /**
     * @return User
     * @throws \Exception
     */
    public function findOne()
    {
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM user" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $entityInfo = $result->fetch();
        $entity = new User($entityInfo['username'],
$entityInfo['password'],
$entityInfo['registerDate'],
$entityInfo['emailVerified'],
$entityInfo['email'],
$entityInfo['createdAt'],
$entityInfo['updatedAt'],
$entityInfo['id']);
        self::$selectedObjectPool[] = $entity;
        return $entity;
    }
    /**
     * @return bool
     * @throws \Exception
     */
    public function delete()
    {
        $db = Database::getInstance('app');
        $this->query = "DELETE FROM user" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        return $result->rowCount() > 0;
    }
    public static function add(User $model)
    {
        if ($model->getId()) {
            throw new \Exception('This entity is not new');
        }
        self::$insertObjectPool[] = $model;
    }
    public static function save()
    {
        foreach (self::$selectedObjectPool as $entity) {
            self::update($entity);
        }
        foreach (self::$insertObjectPool as $entity) {
            self::insert($entity);
        }
        return true;
    }
    private static function update(User $model)
    {
        $db = Database::getInstance('app');
        $query = "UPDATE user SET username= :username, password= :password, registerDate= :registerDate, emailVerified= :emailVerified, email= :email, createdAt= :createdAt, updatedAt= :updatedAt WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':username' => $model->getUsername(),
':password' => $model->getPassword(),
':registerDate' => $model->getRegisterDate(),
':emailVerified' => $model->getEmailVerified(),
':email' => $model->getEmail(),
':createdAt' => $model->getCreatedAt(),
':updatedAt' => $model->getUpdatedAt()
            ]
        );
    }
    private static function insert(User $model)
    {
        $db = Database::getInstance('app');
        $query = "INSERT INTO user (username,password,registerDate,emailVerified,email,createdAt,updatedAt) VALUES (:username, :password, :registerDate, :emailVerified, :email, :createdAt, :updatedAt);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':username' => $model->getUsername(),
':password' => $model->getPassword(),
':registerDate' => $model->getRegisterDate(),
':emailVerified' => $model->getEmailVerified(),
':email' => $model->getEmail(),
':createdAt' => $model->getCreatedAt(),
':updatedAt' => $model->getUpdatedAt()
            ]
        );
        $model->setId($db->lastId());
    }
    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\Models\User');
        $consts = $refc->getConstants();
        return in_array($column, $consts);
    }

    /**
     * @return UserCollection
     * @throws \Exception
     */
    public function pagination($pageNum,$count){

        $param1 = (int)$pageNum;
        $param2 = (int)$count;

        $this->placeholders[] = $pageNum;
        $this->placeholders[] = $count;
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM user" . $this->where. " ORDER BY createdAt DESC LIMIT $param1,$count;";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new User($entityInfo['username'],
$entityInfo['password'],
$entityInfo['registerDate'],
$entityInfo['emailVerified'],
$entityInfo['email'],
$entityInfo['createdAt'],
$entityInfo['updatedAt'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new UserCollection($collection);


    }
}