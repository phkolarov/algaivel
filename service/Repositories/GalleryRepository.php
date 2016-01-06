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
     * @param $post_date
     * @return $this
     */
    public function filterByPost_date($post_date)
    {
        $this->where .= " AND post_date = ?";
        $this->placeholders[] = $post_date;
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
$entityInfo['post_date'],
$entityInfo['category_id'],
$entityInfo['title'],
$entityInfo['description'],
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
$entityInfo['post_date'],
$entityInfo['category_id'],
$entityInfo['title'],
$entityInfo['description'],
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
        $query = "UPDATE gallery SET source= :source, carousel= :carousel, post_date= :post_date, category_id= :category_id, title= :title, description= :description WHERE id = :id";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':id' => $model->getId(),
':source' => $model->getSource(),
':carousel' => $model->getCarousel(),
':post_date' => $model->getPost_date(),
':category_id' => $model->getCategory_id(),
':title' => $model->getTitle(),
':description' => $model->getDescription()
            ]
        );
    }
    private static function insert(Gallery $model)
    {
        $db = Database::getInstance('app');
        $query = "INSERT INTO gallery (source,carousel,post_date,category_id,title,description) VALUES (:source, :carousel, :post_date, :category_id, :title, :description);";
        $result = $db->prepare($query);
        $result->execute(
            [
                ':source' => $model->getSource(),
':carousel' => $model->getCarousel(),
':post_date' => $model->getPost_date(),
':category_id' => $model->getCategory_id(),
':title' => $model->getTitle(),
':description' => $model->getDescription()
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

        $this->placeholders[] = $pageNum;
        $this->placeholders[] = $count;
        $db = Database::getInstance('app');
        $this->query = "SELECT * FROM gallery" . $this->where. " ORDER BY createdAt DESC LIMIT $param1,$count;";
        $result = $db->prepare($this->query);
        $result->execute($this->placeholders);
        $collection = [];
        foreach ($result->fetchAll() as $entityInfo) {
            $entity = new Gallery($entityInfo['source'],
$entityInfo['carousel'],
$entityInfo['post_date'],
$entityInfo['category_id'],
$entityInfo['title'],
$entityInfo['description'],
$entityInfo['id']);
            $collection[] = $entity;
            self::$selectedObjectPool[] = $entity;
        }
        return new GalleryCollection($collection);


    }
}