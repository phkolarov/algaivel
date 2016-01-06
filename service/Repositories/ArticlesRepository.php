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
     * @param $introNewsData
     * @return $this
     */
    public function filterByIntroNewsData($introNewsData)
    {
        $this->where .= " AND introNewsData = ?";
        $this->placeholders[] = $introNewsData;
        return $this;
    }    /**
     * @param $newsData
     * @return $this
     */
    public function filterByNewsData($newsData)
    {
        $this->where .= " AND newsData = ?";
        $this->placeholders[] = $newsData;
        return $this;
    }    /**
     * @param $picture
     * @return $this
     */
    public function filterByPicture($picture)
    {
        $this->where .= " AND picture = ?";
        $this->placeholders[] = $picture;
        return $this;
    }    /**
     * @param $thumbnail
     * @return $this
     */
    public function filterByThumbnail($thumbnail)
    {
        $this->where .= " AND thumbnail = ?";
        $this->placeholders[] = $thumbnail;
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
     * @param $category_id
     * @return $this
     */
    public function filterByCategory_id($category_id)
    {
        $this->where .= " AND category_id = ?";
        $this->placeholders[] = $category_id;
        return $this;
    }    /**
     * @param $isPosted
     * @return $this
     */
    public function filterByIsPosted($isPosted)
    {
        $this->where .= " AND isPosted = ?";
        $this->placeholders[] = $isPosted;
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
$entityInfo['introNewsData'],
$entityInfo['newsData'],
$entityInfo['picture'],
$entityInfo['thumbnail'],
$entityInfo['createdAt'],
$entityInfo['category_id'],
$entityInfo['isPosted'],
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
$entityInfo['introNewsData'],
$entityInfo['newsData'],
$entityInfo['picture'],
$entityInfo['thumbnail'],
$entityInfo['createdAt'],
$entityInfo['category_id'],
$entityInfo['isPosted'],
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
        $query = "UPDATE articles SET title= :title, introNewsData= :introNewsData, newsData= :newsData, picture= :picture, thumbnail= :thumbnail, createdAt= :createdAt, category_id= :category_id, isPosted= :isPosted WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':title' => $model->getTitle(),
':introNewsData' => $model->getIntroNewsData(),
':newsData' => $model->getNewsData(),
':picture' => $model->getPicture(),
':thumbnail' => $model->getThumbnail(),
':createdAt' => $model->getCreatedAt(),
':category_id' => $model->getCategory_id(),
':isPosted' => $model->getIsPosted()
            ]
        );
    }
    private static function insert(Article $model)
    {
        $db = Database::getInstance('app');
        $query = "INSERT INTO articles (title,introNewsData,newsData,picture,thumbnail,createdAt,category_id,isPosted) VALUES (:title, :introNewsData, :newsData, :picture, :thumbnail, :createdAt, :category_id, :isPosted);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':title' => $model->getTitle(),
':introNewsData' => $model->getIntroNewsData(),
':newsData' => $model->getNewsData(),
':picture' => $model->getPicture(),
':thumbnail' => $model->getThumbnail(),
':createdAt' => $model->getCreatedAt(),
':category_id' => $model->getCategory_id(),
':isPosted' => $model->getIsPosted()
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
        $this->query = "SELECT * FROM articles" . $this->where. " ORDER BY createdAt DESC LIMIT $param1,$count;";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Article($entityInfo['title'],
$entityInfo['introNewsData'],
$entityInfo['newsData'],
$entityInfo['picture'],
$entityInfo['thumbnail'],
$entityInfo['createdAt'],
$entityInfo['category_id'],
$entityInfo['isPosted'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new ArticleCollection($collection);


    }
}