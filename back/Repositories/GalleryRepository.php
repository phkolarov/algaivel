<?php
namespace Repositories;

use Core\Database;
use Models\Gallery;
use Collections\GalleryCollection;

class GalleryRepository
{
    private $query;
    private $where = " WHERE 1";
    private $placeholders = [];
    private $order = '';
    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];
    /**
     * @var GalleryRepository
     */
    private static $inst = null;
    private function __construct() { }
    /**
     * @return GalleryRepository
     */
    public static function create()
    {
        if (self::$inst == null) {
        }
        self::$selectedObjectPool = [];
        self::$insertObjectPool = [];
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
     * @param $source
     * @return $this
     */
    public function filterBySource($source)
    {
        $this->where .= " AND source = ?";
        $this->placeholders[] = $source;
        return $this;
    }    /**
     * @param $carousel
     * @return $this
     */
    public function filterByCarousel($carousel)
    {
        $this->where .= " AND carousel = ?";
        $this->placeholders[] = $carousel;
        return $this;
    }    /**
     * @param $title
     * @return $this
     */
    public function filterByTitle($title)
    {
        $this->where .= " AND title = ?";
        $this->placeholders[] = $title;
        return $this;
    }    /**
     * @param $description
     * @return $this
     */
    public function filterByDescription($description)
    {
        $this->where .= " AND description = ?";
        $this->placeholders[] = $description;
        return $this;
    }    /**
     * @param $post_date
     * @return $this
     */
    public function filterByPost_date($post_date)
    {
        $this->where .= " AND post_date = ?";
        $this->placeholders[] = $post_date;
        return $this;
    }    /**
     * @param $titleBG
     * @return $this
     */
    public function filterByTitleBG($titleBG)
    {
        $this->where .= " AND titleBG = ?";
        $this->placeholders[] = $titleBG;
        return $this;
    }    /**
     * @param $descriptionBG
     * @return $this
     */
    public function filterByDescriptionBG($descriptionBG)
    {
        $this->where .= " AND descriptionBG = ?";
        $this->placeholders[] = $descriptionBG;
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
     * @param $column
     * @param $value
     * @return $this
     */
     public function customOr($column,$value){

         if(!strpos($this->where,'AND')){

                $this->where .= " AND ";
                $this->where .= "$column Like ?";
                $this->placeholders[] = '%'.$value.'%';
                return $this;
         }else{

         $this->where .= " OR $column Like ?";
                $this->placeholders[] = '%'.$value.'%';
                return $this;
         }


     }


    /**
     * @param $column
     * @param $value
     * @return $this
     */
     public function customWhere($column,$value){

         $this->where .= " AND $column Like ?";
         $this->placeholders[] = $value;
         return $this;

     }

    /**
     * @return GalleryCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM gallery" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Gallery($entityInfo['source'],
$entityInfo['carousel'],
$entityInfo['title'],
$entityInfo['description'],
$entityInfo['post_date'],
$entityInfo['titleBG'],
$entityInfo['descriptionBG'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new GalleryCollection($collection);
    }
    /**
     * @return Gallery
     * @throws \Exception
     */
    public function findOne()
    {
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM gallery" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $entityInfo = $result->fetch();
        $entity = new Gallery($entityInfo['source'],
$entityInfo['carousel'],
$entityInfo['title'],
$entityInfo['description'],
$entityInfo['post_date'],
$entityInfo['titleBG'],
$entityInfo['descriptionBG'],
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
        $this->query = "DELETE FROM gallery" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        return $result->rowCount() > 0;
    }
    public static function add(Gallery $model)
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
    private static function update(Gallery $model)
    {
        $db = Database::getInstance('app');
        $query = "UPDATE gallery SET source= :source, carousel= :carousel, title= :title, description= :description, post_date= :post_date, titleBG= :titleBG, descriptionBG= :descriptionBG WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':source' => $model->getSource(),
':carousel' => $model->getCarousel(),
':title' => $model->getTitle(),
':description' => $model->getDescription(),
':post_date' => $model->getPost_date(),
':titleBG' => $model->getTitleBG(),
':descriptionBG' => $model->getDescriptionBG()
            ]
        );
    }
    private static function insert(Gallery $model)
    {
        $db = Database::getInstance('app');
        $query = "INSERT INTO gallery (source,carousel,title,description,post_date,titleBG,descriptionBG) VALUES (:source, :carousel, :title, :description, :post_date, :titleBG, :descriptionBG);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':source' => $model->getSource(),
':carousel' => $model->getCarousel(),
':title' => $model->getTitle(),
':description' => $model->getDescription(),
':post_date' => $model->getPost_date(),
':titleBG' => $model->getTitleBG(),
':descriptionBG' => $model->getDescriptionBG()
            ]
        );
        $model->setId($db->lastId());
    }
    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\Models\Gallery');
        $consts = $refc->getConstants();
        return in_array($column, $consts);
    }

    /**
     * @return GalleryCollection
     * @throws \Exception
     */
    public function pagination($pageNum,$count){

        $param1 = (int)$pageNum;
        $param2 = (int)$count;

        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM gallery" . $this->where. " ORDER BY post_date DESC LIMIT $param1,$count;";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Gallery($entityInfo['source'],
$entityInfo['carousel'],
$entityInfo['title'],
$entityInfo['description'],
$entityInfo['post_date'],
$entityInfo['titleBG'],
$entityInfo['descriptionBG'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new GalleryCollection($collection);
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

            $this->query = "FROM gallery";
        }

        if(isset($customJOIN)){
            $table1Name = $customJOIN;
        }else{
            $table1Name = "gallery";
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