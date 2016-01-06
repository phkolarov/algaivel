<?php
namespace Repositories;

use Core\Database;
use Models\User;
use Collections\UserCollection;

class UsersRepository
{
    private $query;
    private $where = " WHERE 1";
    private $placeholders = [];
    private $order = '';
    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];
    /**
     * @var UsersRepository
     */
    private static $inst = null;
    private function __construct() { }
    /**
     * @return UsersRepository
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
     * @param $email
     * @return $this
     */
    public function filterByEmail($email)
    {
        $this->where .= " AND email = ?";
        $this->placeholders[] = $email;
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
     * @param $role_id
     * @return $this
     */
    public function filterByRole_id($role_id)
    {
        $this->where .= " AND role_id = ?";
        $this->placeholders[] = $role_id;
        return $this;
    }    /**
     * @param $f_name
     * @return $this
     */
    public function filterByF_name($f_name)
    {
        $this->where .= " AND f_name = ?";
        $this->placeholders[] = $f_name;
        return $this;
    }    /**
     * @param $l_name
     * @return $this
     */
    public function filterByL_name($l_name)
    {
        $this->where .= " AND l_name = ?";
        $this->placeholders[] = $l_name;
        return $this;
    }    /**
     * @param $gender
     * @return $this
     */
    public function filterByGender($gender)
    {
        $this->where .= " AND gender = ?";
        $this->placeholders[] = $gender;
        return $this;
    }    /**
     * @param $date_of_birth
     * @return $this
     */
    public function filterByDate_of_birth($date_of_birth)
    {
        $this->where .= " AND date_of_birth = ?";
        $this->placeholders[] = $date_of_birth;
        return $this;
    }    /**
     * @param $registered_at
     * @return $this
     */
    public function filterByRegistered_at($registered_at)
    {
        $this->where .= " AND registered_at = ?";
        $this->placeholders[] = $registered_at;
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
        $this->query = "SELECT * FROM users" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new User($entityInfo['username'],
$entityInfo['email'],
$entityInfo['password'],
$entityInfo['role_id'],
$entityInfo['f_name'],
$entityInfo['l_name'],
$entityInfo['gender'],
$entityInfo['date_of_birth'],
$entityInfo['registered_at'],
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
        $this->query = "SELECT * FROM users" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $entityInfo = $result->fetch();
        $entity = new User($entityInfo['username'],
$entityInfo['email'],
$entityInfo['password'],
$entityInfo['role_id'],
$entityInfo['f_name'],
$entityInfo['l_name'],
$entityInfo['gender'],
$entityInfo['date_of_birth'],
$entityInfo['registered_at'],
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
        $this->query = "DELETE FROM users" . $this->where;
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
        $query = "UPDATE users SET username= :username, email= :email, password= :password, role_id= :role_id, f_name= :f_name, l_name= :l_name, gender= :gender, date_of_birth= :date_of_birth, registered_at= :registered_at WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':username' => $model->getUsername(),
':email' => $model->getEmail(),
':password' => $model->getPassword(),
':role_id' => $model->getRole_id(),
':f_name' => $model->getF_name(),
':l_name' => $model->getL_name(),
':gender' => $model->getGender(),
':date_of_birth' => $model->getDate_of_birth(),
':registered_at' => $model->getRegistered_at()
            ]
        );
    }
    private static function insert(User $model)
    {
        $db = Database::getInstance('app');
        $query = "INSERT INTO users (username,email,password,role_id,f_name,l_name,gender,date_of_birth,registered_at) VALUES (:username, :email, :password, :role_id, :f_name, :l_name, :gender, :date_of_birth, :registered_at);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':username' => $model->getUsername(),
':email' => $model->getEmail(),
':password' => $model->getPassword(),
':role_id' => $model->getRole_id(),
':f_name' => $model->getF_name(),
':l_name' => $model->getL_name(),
':gender' => $model->getGender(),
':date_of_birth' => $model->getDate_of_birth(),
':registered_at' => $model->getRegistered_at()
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
        $this->query = "SELECT * FROM users" . $this->where. " ORDER BY createdAt DESC LIMIT $param1,$count;";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new User($entityInfo['username'],
$entityInfo['email'],
$entityInfo['password'],
$entityInfo['role_id'],
$entityInfo['f_name'],
$entityInfo['l_name'],
$entityInfo['gender'],
$entityInfo['date_of_birth'],
$entityInfo['registered_at'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new UserCollection($collection);


    }
}