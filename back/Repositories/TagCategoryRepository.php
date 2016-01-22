<?php
namespace Repositories;

use Core\Database;
use Models\TagCategory;
use Collections\TagCategoryCollection;

class TagCategoryRepository
{
    private $query;
    private $where = " WHERE 1";
    private $placeholders = [];
    private $order = '';
    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];
    /**
     * @var TagCategoryRepository
     */
    private static $inst = null;
    private function __construct() { }
    /**
     * @return TagCategoryRepository
     */
    public static function create()
    {
        if (self::$inst == null) {
        }
        self::$inst = new self();
        return self::$inst;
    }

    /**
     * @param $columnName
     * @param $value
     * @return $this
     */
    public function andGet($columnName,$value)
    {
        if(strpos($this->where,"AND $columnName =")){
            $this->where .= " OR $columnName = ?";
            $this->placeholders[] = $value;
            return $this;
        }else{
            $this->where .= " AND $columnName = ?";
            $this->placeholders[] = $value;
            return $this;
        }

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
     * @param $name
     * @return $this
     */
    public function filterByName($name)
    {
        $this->where .= " AND name = ?";
        $this->placeholders[] = $name;
        return $this;
    }    /**
     * @param $nameBG
     * @return $this
     */
    public function filterByNameBG($nameBG)
    {
        $this->where .= " AND nameBG = ?";
        $this->placeholders[] = $nameBG;
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
     * @param $query
     * @return $this
     */
     public function customWhere($query){

              $this->where .= " AND " .$query;
              return $this;
     }

    /**
     * @return TagCategoryCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM tag_category" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new TagCategory($entityInfo['name'],
$entityInfo['nameBG'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new TagCategoryCollection($collection);
    }
    /**
     * @return TagCategory
     * @throws \Exception
     */
    public function findOne()
    {
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM tag_category" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $entityInfo = $result->fetch();
        $entity = new TagCategory($entityInfo['name'],
$entityInfo['nameBG'],
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
        $this->query = "DELETE FROM tag_category" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        return $result->rowCount() > 0;
    }
    public static function add(TagCategory $model)
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
    private static function update(TagCategory $model)
    {
        $db = Database::getInstance('app');
        $query = "UPDATE tag_category SET name= :name, nameBG= :nameBG WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':name' => $model->getName(),
':nameBG' => $model->getNameBG()
            ]
        );
    }
    private static function insert(TagCategory $model)
    {
        $db = Database::getInstance('app');
        $query = "INSERT INTO tag_category (name,nameBG) VALUES (:name, :nameBG);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':name' => $model->getName(),
':nameBG' => $model->getNameBG()
            ]
        );
        $model->setId($db->lastId());
    }
    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\Models\TagCategory');
        $consts = $refc->getConstants();
        return in_array($column, $consts);
    }

    /**
     * @return TagCategoryCollection
     * @throws \Exception
     */
    public function pagination($pageNum,$count){

        $param1 = (int)$pageNum;
        $param2 = (int)$count;

        $this->placeholders[] = $pageNum;
        $this->placeholders[] = $count;
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM tag_category" . $this->where. " ORDER BY post_date DESC LIMIT $param1,$count;";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new TagCategory($entityInfo['name'],
$entityInfo['nameBG'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new TagCategoryCollection($collection);


    }

      /**
     * @param $table2Name
     * @param $table2param
     * @param $comparator
     * @param $table1param
     * @param $customJOIN
     */
    public function join($table2Name,$table2param,$comparator,$table1param,$customJOIN){

        if($this->query == null){

            $this->query = "FROM tag_category";
        }

        if(isset($customJOIN)){
            $table1Name = $customJOIN;
        }else{
            $table1Name = "tag_category";
        }

        if($this->query == " WHERE 1"){
            $this->query = "";
        }

        $this->query .= " JOIN $table2Name ON $table2Name.$table2param $comparator $table1Name.$table1param ";
    }

     /**
     * @param $tableParam
     * @param $value
     */
    public function qor($tableParam, $value){

        if($this->where == " WHERE 1"){

            $this->where .= " AND (".$tableParam." = '".$value."'";
        }else if(strpos($this->where,") AND ") > 0 && strpos($this->where,") AND (") == false ){

                $this->where .= "(".$tableParam." = '".$value."'";

        }else{

            $this->where .= " OR ".$tableParam." = '".$value."'";
        }
    }

    /**
     * @param bool|false $andOR
     */
    public function endqor($andOR = false){

        $this->where .= ")";
        if($andOR == true){
            $this->where .= " AND ";
        }
    }

    /**
     * @param null $parameters
     */
    public function select($parameters = null){

        $parametersString = "";

       if(count($parameters) > 0){

           foreach($parameters as $param){

               $parametersString .= $param.",";
           }
       }else{
           $parameters = "*";
       }

        $parametersString = trim($parametersString,",");
        $parameters = "SELECT ".$parametersString." ";
        $this->query = $parameters.$this->query;
    }

    /**
     * @param null $page
     * @param null $count
     * @return object
     * @throws \Exception
     */
    public function get($page = null,$count = null){

        $query = $this->query.$this->where;

        if(!is_null($page) && is_null($count)){
            $query.= " LIMIT $page;";
        }else if(!is_null($page)  && !is_null($count)){
            $page = $page * $count;
            $query.= " LIMIT $page,$count;";
        }

        $db = Database::getInstance('app');
        $result = $db->prepare($query);
        $result->execute();

        $customObject = $result->fetchAll();

        $outPutObject = (object)array("results"=> $customObject);

        return $outPutObject;

    }

}