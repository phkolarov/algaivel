<?php
namespace Repositories;

use Core\Database;
use Models\Article;
use Collections\ArticleCollection;

class ArticlesRepository
{
    private $query;
    private $where = " WHERE 1";
    private $placeholders = [];
    private $order = '';
    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];
    /**
     * @var ArticlesRepository
     */
    private static $inst = null;
    private function __construct() { }
    /**
     * @return ArticlesRepository
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
     * @param $title
     * @return $this
     */
    public function filterByTitle($title)
    {
        $this->where .= " AND title = ?";
        $this->placeholders[] = $title;
        return $this;
    }    /**
     * @param $content
     * @return $this
     */
    public function filterByContent($content)
    {
        $this->where .= " AND content = ?";
        $this->placeholders[] = $content;
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
     * @param $articleImage
     * @return $this
     */
    public function filterByArticleImage($articleImage)
    {
        $this->where .= " AND articleImage = ?";
        $this->placeholders[] = $articleImage;
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
     * @param $contentBG
     * @return $this
     */
    public function filterByContentBG($contentBG)
    {
        $this->where .= " AND contentBG = ?";
        $this->placeholders[] = $contentBG;
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
     * @return ArticleCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM articles" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Article($entityInfo['title'],
$entityInfo['content'],
$entityInfo['post_date'],
$entityInfo['articleImage'],
$entityInfo['titleBG'],
$entityInfo['contentBG'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new ArticleCollection($collection);
    }
    /**
     * @return Article
     * @throws \Exception
     */
    public function findOne()
    {
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM articles" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $entityInfo = $result->fetch();
        $entity = new Article($entityInfo['title'],
$entityInfo['content'],
$entityInfo['post_date'],
$entityInfo['articleImage'],
$entityInfo['titleBG'],
$entityInfo['contentBG'],
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
        $this->query = "DELETE FROM articles" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        return $result->rowCount() > 0;
    }
    public static function add(Article $model)
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
    private static function update(Article $model)
    {
        $db = Database::getInstance('app');
        $query = "UPDATE articles SET title= :title, content= :content, post_date= :post_date, articleImage= :articleImage, titleBG= :titleBG, contentBG= :contentBG WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':title' => $model->getTitle(),
':content' => $model->getContent(),
':post_date' => $model->getPost_date(),
':articleImage' => $model->getArticleImage(),
':titleBG' => $model->getTitleBG(),
':contentBG' => $model->getContentBG()
            ]
        );
    }
    private static function insert(Article $model)
    {
        $db = Database::getInstance('app');
        $query = "INSERT INTO articles (title,content,post_date,articleImage,titleBG,contentBG) VALUES (:title, :content, :post_date, :articleImage, :titleBG, :contentBG);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':title' => $model->getTitle(),
':content' => $model->getContent(),
':post_date' => $model->getPost_date(),
':articleImage' => $model->getArticleImage(),
':titleBG' => $model->getTitleBG(),
':contentBG' => $model->getContentBG()
            ]
        );
        $model->setId($db->lastId());
    }
    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\Models\Article');
        $consts = $refc->getConstants();
        return in_array($column, $consts);
    }

    /**
     * @return ArticleCollection
     * @throws \Exception
     */
    public function pagination($pageNum,$count){

        $param1 = (int)$pageNum;
        $param2 = (int)$count;

        $this->placeholders[] = $pageNum;
        $this->placeholders[] = $count;
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM articles" . $this->where. " ORDER BY post_date DESC LIMIT $param1,$count;";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Article($entityInfo['title'],
$entityInfo['content'],
$entityInfo['post_date'],
$entityInfo['articleImage'],
$entityInfo['titleBG'],
$entityInfo['contentBG'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new ArticleCollection($collection);


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

            $this->query = "FROM articles";
        }

        if(isset($customJOIN)){
            $table1Name = $customJOIN;
        }else{
            $table1Name = "articles";
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