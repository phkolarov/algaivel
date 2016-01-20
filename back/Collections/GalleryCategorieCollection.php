<?php
namespace Collections;
use Models\GalleryCategorie;
class GalleryCategorieCollection
{
    /**
     * @var GalleryCategorie[];
     */
    private $collection = [];
    private $publicCollection = [];
    public function __construct($models = [])
    {
        $this->collection = $models;
    }
    /**
     * @param callable $callback
     */
    public function each(Callable $callback)
    {
        $arr = [];
        foreach ($this->collection as $model) {
          $funcCallback = $callback($model);

            array_push($arr,$funcCallback);
        }
        return (object)array("results" => $arr);
    }

    public function getObject(){

        foreach ($this->collection as $item) {
            array_push($this->publicCollection,$item->FullObjectGeter());
        }

        $resultObject = (object)array("results" => $this->publicCollection);

        return $resultObject;
    }
}