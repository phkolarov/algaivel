<?php
namespace Repositories;

use Core\Database;
use Models\Video;
use Collections\VideoCollection;

class VideosRepository
{
    private $query;
    private $where = " WHERE 1";
    private $placeholders = [];
    private $order = '';
    private static $selectedObjectPool = [];
    private static $insertObjectPool = [];
    /**
     * @var VideosRepository
     */
    private static $inst = null;
    private function __construct() { }
    /**
     * @return VideosRepository
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
     * @param $name
     * @return $this
     */
    public function filterByName($name)
    {
        $this->where .= " AND name = ?";
        $this->placeholders[] = $name;
        return $this;
    }    /**
     * @param $comment
     * @return $this
     */
    public function filterByComment($comment)
    {
        $this->where .= " AND comment = ?";
        $this->placeholders[] = $comment;
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
     * @param $link
     * @return $this
     */
    public function filterByLink($link)
    {
        $this->where .= " AND link = ?";
        $this->placeholders[] = $link;
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
     * @return VideoCollection
     * @throws \Exception
     */
    public function findAll()
    {
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM videos" . $this->where . $this->order;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Video($entityInfo['name'],
$entityInfo['comment'],
$entityInfo['thumbnail'],
$entityInfo['createdAt'],
$entityInfo['link'],
$entityInfo['category_id'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new VideoCollection($collection);
    }
    /**
     * @return Video
     * @throws \Exception
     */
    public function findOne()
    {
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM videos" . $this->where . $this->order . " LIMIT 1";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $entityInfo = $result->fetch();
        $entity = new Video($entityInfo['name'],
$entityInfo['comment'],
$entityInfo['thumbnail'],
$entityInfo['createdAt'],
$entityInfo['link'],
$entityInfo['category_id'],
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
        $this->query = "DELETE FROM videos" . $this->where;
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        return $result->rowCount() > 0;
    }
    public static function add(Video $model)
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
    private static function update(Video $model)
    {
        $db = Database::getInstance('app');
        $query = "UPDATE videos SET name= :name, comment= :comment, thumbnail= :thumbnail, createdAt= :createdAt, link= :link, category_id= :category_id WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':name' => $model->getName(),
':comment' => $model->getComment(),
':thumbnail' => $model->getThumbnail(),
':createdAt' => $model->getCreatedAt(),
':link' => $model->getLink(),
':category_id' => $model->getCategory_id()
            ]
        );
    }
    private static function insert(Video $model)
    {
        $db = Database::getInstance('app');
        $query = "INSERT INTO videos (name,comment,thumbnail,createdAt,link,category_id) VALUES (:name, :comment, :thumbnail, :createdAt, :link, :category_id);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':name' => $model->getName(),
':comment' => $model->getComment(),
':thumbnail' => $model->getThumbnail(),
':createdAt' => $model->getCreatedAt(),
':link' => $model->getLink(),
':category_id' => $model->getCategory_id()
            ]
        );
        $model->setId($db->lastId());
    }
    private function isColumnAllowed($column)
    {
        $refc = new \ReflectionClass('\Models\Video');
        $consts = $refc->getConstants();
        return in_array($column, $consts);
    }

    /**
     * @return VideoCollection
     * @throws \Exception
     */
    public function pagination($pageNum,$count){

        $param1 = (int)$pageNum;
        $param2 = (int)$count;

        $this->placeholders[] = $pageNum;
        $this->placeholders[] = $count;
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM videos" . $this->where. " ORDER BY createdAt DESC LIMIT $param1,$count;";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Video($entityInfo['name'],
$entityInfo['comment'],
$entityInfo['thumbnail'],
$entityInfo['createdAt'],
$entityInfo['link'],
$entityInfo['category_id'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new VideoCollection($collection);


    }
}