<?php

namespace controllers\defaultControllers;


use Models\Gallery;
use Repositories\CategoriesRepository;
use Repositories\GalleryCategoriesRepository;
use Repositories\GalleryRepository;

class GalleryController
{

    /**
     * @param $parameters
     */
    public function index($parameters)
    {

        $filterParams = (object)array();
        $page = $parameters[0];
        $count = $parameters[1];


        if ($_SERVER['REQUEST_METHOD'] == "GET") {

            $images = $this->pagination($page, $count, null);

            //MUST BE ENCODED TO JSON!!!
            var_dump($images);

        } else if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $parsedJSON = json_decode(file_get_contents('php://input'));

            $groups = $parsedJSON->groups;
            $filters = $parsedJSON->filters;
            $images = $this->getImageObjectGroup($groups);

           if(count($filters) > 0){

               $images = $this->filterImagesByCategories($images,$filters);
           }



            //header("Content-Type: application/json");
            //echo json_encode($images);
        }


    }

    /**
     * @param $page
     * @param $count
     * @param $paramsForFilters
     * @return \Collections\GalleryCollection
     */
    private function pagination($page, $count, $paramsForFilters)
    {

        $startIndex = $page * $count;
        $imagesRepo = GalleryRepository::create();

        if (isset($paramsForFilters)) {

            foreach ($paramsForFilters as $param) {

                var_dump($param);
            }
        }
        return $imagesRepo->pagination($startIndex, $count);
    }

    /**
     * @param $groups
     * @return object
     */
    private function getImageObjectGroup($groups)
    {
        $imageRepo = GalleryRepository::create();
        $groupRepo = CategoriesRepository::create();
        $imageCategoryRepo = GalleryCategoriesRepository::create();

        foreach ($groups as $groupName) {
            $groupRepo->andGet("name",$groupName);
        }

        $currentGroups = $groupRepo->findAll();
        $groupObjects =$currentGroups->getObject();

        foreach($groupObjects->results as $groupObject){
            //var_dump($groupObject);
            $imageCategoryRepo->andGet("category_id",$groupObject->id);
        }

        $currentImgCategories = $imageCategoryRepo->findAll();
        $currentImgCatObjects = $currentImgCategories->getObject();

        foreach ($currentImgCatObjects->results as $imgCatObj) {

            $imageRepo->andGet("id",$imgCatObj->gallery_id);
        }
        $currentImages =$imageRepo->findAll();
        $outputImagesObject = $currentImages->getObject();

        return $outputImagesObject;
    }


    private function filterImagesByCategories($imgObjects,$filters){


        

       foreach($filters as $filterName){

           var_dump($filters);
       }
    }


}