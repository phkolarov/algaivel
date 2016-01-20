<?php

namespace controllers\defaultControllers;


use Models\Gallery;
use Repositories\CategoriesRepository;
use Repositories\GalleryCategoriesRepository;
use Repositories\GalleryRepository;
use Repositories\GalleryTagsRepository;
use Repositories\TagCategoryRepository;
use Repositories\TagsCategoriesRepository;
use Repositories\TagsRepository;

class GalleryController
{

    /**
     * @param $parameters
     * return json
     */
    public function index($parameters)
    {

        $page = $parameters[0];
        $count = $parameters[1];


        if ($_SERVER['REQUEST_METHOD'] == "GET") {


            $imagesRepoCount = GalleryRepository::create();

            //IS THIS ORDERED CORRECTLY????

            $allImages = $imagesRepoCount->findAll();
            $publicImagesObject = $allImages->getObject();
            $allImagesCount = count($publicImagesObject->results);
            $images = $this->pagination($page, $count, null);
            $imagesObject = $images->getObject();
            $imagesObject->countOfImages = $allImagesCount;

            header("Content-Type: application/json");
            echo json_encode($imagesObject);

        } else if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $parsedJSON = json_decode(file_get_contents('php://input'));
            $groups = $parsedJSON->groups;
            $filters = $parsedJSON->tags;

            $images = $this->getFilteredGallery($groups, $filters, $page, $count);

            header("Content-Type: application/json");
            echo json_encode($images);
        }


    }

    /**
     * @GET
     * @param $param
     * return json
     */
    public function pageCounter($param)
    {

        $count = (int)$param[0];
//        $currentPage = $param[1];
        $imageRepo = GalleryRepository::create();

        $allImages = $imageRepo->findAll();

        $imagesObject = $allImages->getObject();

        $countexpression = count($imagesObject->results) / $count;

        $pageCount = floor($countexpression);
//        $remaining = count($imagesObject->results) - ($currentPage * $count);

        if ($countexpression % $count > 0) {
            $pageCount += 1;
        }

        header("Content-Type: application/json");
        echo json_encode((object)array("results" => ["pages" => $pageCount]));
    }

    /*
     * @GET
     * return json
     */
    public function getTagCategories()
    {


        $tagCategoriesRepo = TagsCategoriesRepository::create();


        $tagCategoriesRepo->join("tag_category", "id", "=", "tag_category_id", null);
        $tagCategoriesRepo->join("tags", "id", "=", "tag_id", null);
        $tagCategoriesRepo->select(["tags.id as tagId,tags.name as tagName, tags.nameBG as tagNameBG,tag_category.id as tagCategoryId, tag_category.name as tagCategoryName,tag_category.nameBG as tagCategoryNameBG"]);
        $categories = $tagCategoriesRepo->get();
        $categoriesOutPutObject = [];
        $allGroups = $this->getGroupNames();

        foreach ($categories->results as $category) {

            $categoryObject = (object)array(
                "name" => array($category['tagCategoryId'], $category['tagCategoryName'], $category['tagCategoryNameBG']),
                "catObject" => $category
            );

            foreach ($allGroups as $group) {

                if ($group->id == $categoryObject->name[0]) {
                    array_push($group->elements, $categoryObject->catObject);
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode((object)array("results" => $allGroups));
    }


    /**
     * @POST
     * @param $id
     */
    public function getCurrentImage($parameters)
    {

        $parsedJSON = json_decode(file_get_contents('php://input'));
        $groups = $parsedJSON->groups;
        $filters = $parsedJSON->tags;
        $currentImageId = $parameters[0];
        $images = $this->getFilteredGallery($groups, $filters, 0, 99999);

        if (count($groups) == 0) {

            $prvImages = $this->pagination(0, 99999);

            $images = $prvImages->getObject();

            for ($t = 0; $t < count($images->results); $t++) {


                if ($images->results[$t]->id == $currentImageId) {

                    if ($t == 0) {
                        $images->results[$t]->firstOne = true;
                    } else {
                        $images->results[$t]->firstOne = false;
                    }

                    if ($t == (count($images->results) - 1)) {
                        $images->results[$t]->lastOne = true;
                    } else {
                        $images->results[$t]->lastOne = false;
                    }

                    header("Content-type: application/json");
                    echo json_encode((object)array("results" => $images->results[$t]));
                    break;
                }
            }

        } else {

            for ($i = 0; $i < count($images->results); $i++) {
                for ($k = $i + 1; $k < count($images->results); $k++) {

                    if ($images->results[$i]['id'] == $images->results[$k]['id']) {

                        $element = array_search($images->results[$i], $images->results);

                        array_splice($images->results, $element, 1);
                    }
                }
            }

            for ($t = 0; $t < count($images->results); $t++) {



                if ($images->results[$t]['id'] == $currentImageId) {



                    if ($t == (count($images->results) - 1)) {

                        $images->results[$t]['lastOne'] = true;

                    } else {

                        $images->results[$t]['lastOne'] = false;
                    }

                    if ($t == 0) {

                        $images->results[$t]['firstOne'] = true;

                    } else {
                        $images->results[$t]['firstOne'] = false;
                    }
                    header("Content-type: application/json");
                    echo json_encode((object)array("results" => $images->results[$t]));
                    break;

                }
            }
        }


    }


    /**
     * @POST
     * @param $parameters
     */
    public function getNextImageWithCustomFiltration($parameters)
    {


        $parsedJSON = json_decode(file_get_contents('php://input'));
        $groups = $parsedJSON->groups;
        $filters = $parsedJSON->tags;
        $currentImageId = $parameters[0];
        $images = $this->getFilteredGallery($groups, $filters, 0, 99999);

        if (count($groups) == 0) {


            $prvImages = $this->pagination(0, 99999);

            $images = $prvImages->getObject();

            for ($t = 0; $t < count($images->results); $t++) {


                if ($images->results[$t]->id == $currentImageId) {

                    if ($t == (count($images->results) - 1)) {

                        header("Content-type: application/json");
                        echo json_encode((object)array("results" => "not exist"));
                        break;
                    } else {

                        if ($t == (count($images->results) - 2)) {

                            $images->results[$t + 1]->lastOne = true;
                        } else {

                            $images->results[$t + 1]->lastOne = false;
                        }

                        if($t == 0){
                            $images->results[$t + 1]->firstOne = true;
                        }else{

                            $images->results[$t + 1]->firstOne = false;
                        }

                        header("Content-type: application/json");
                        echo json_encode((object)array("results" => $images->results[$t + 1]));
                        break;
                    }
                }
            }


        } else {
            for ($i = 0; $i < count($images->results); $i++) {
                for ($k = $i + 1; $k < count($images->results); $k++) {

                    if ($images->results[$i]['id'] == $images->results[$k]['id']) {

                        $element = array_search($images->results[$i], $images->results);

                        array_splice($images->results, $element, 1);
                    }
                }
            }

            for ($t = 0; $t < count($images->results); $t++) {


                if ($images->results[$t]['id'] == $currentImageId) {

                    if ($t == (count($images->results) - 1)) {

                        header("Content-type: application/json");
                        echo json_encode((object)array("results" => "not exist"));
                        break;
                    } else {

                        if ($t == (count($images->results) - 2)) {

                            $images->results[$t + 1]['lastOne'] = true;
                        } else {
                            $images->results[$t + 1]['lastOne'] = false;
                        }
                        if($t == 0){


                            $images->results[$t + 1]['firstOne'] = true;
                        }else{
                            $images->results[$t + 1]['firstOne'] = false;
                        }

                        header("Content-type: application/json");
                        echo json_encode((object)array("results" => $images->results[$t + 1]));
                        break;
                    }
                }
            }
        }


    }

    /**
     * @POST
     * @param $parameters
     */
    public function getPreviousImageWithCustomFiltration($parameters)
    {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $parsedJSON = json_decode(file_get_contents('php://input'));
            $groups = $parsedJSON->groups;
            $filters = $parsedJSON->tags;
            $currentImageId = $parameters[0];
            $images = '';

            if (count($groups) == 0) {

                $prvImages = $this->pagination(0, 99999);

                $images = $prvImages->getObject();

                for ($t = count($images->results) - 1; $t >= 0; $t--) {


                    if ($images->results[$t]->id == $currentImageId) {

                        if ($t == 0) {

                            header("Content-type: application/json");
                            echo json_encode((object)array("results" => "no exist"));

                        } else {

                            if ($t - 1 == 0) {

                                $images->results[$t - 1]->firstOne = true;

                            } else {

                                $images->results[$t - 1]->firstOne = false;
                            }
                            if($t == (count($images->results[$t]) - 1)){


                                $images->results[$t - 1]->lastOne = true;
                            }else{

                                $images->results[$t - 1]->lastOne = false;
                            }


                            header("Content-type: application/json");
                            echo json_encode((object)array("results" => $images->results[$t - 1]));

                        }
                    }
                }

            } else {
                $images = $this->getFilteredGallery($groups, $filters, 0, 99999);

                for ($i = 0; $i < count($images->results); $i++) {
                    for ($k = $i + 1; $k < count($images->results); $k++) {

                        if ($images->results[$i]['id'] == $images->results[$k]['id']) {

                            $element = array_search($images->results[$i], $images->results);

                            array_splice($images->results, $element, 1);
                        }
                    }
                }

                for ($t = count($images->results) - 1; $t >= 0; $t--) {


                    if ($images->results[$t]['id'] == $currentImageId) {

                        if ($t == 0) {

                            header("Content-type: application/json");
                            echo json_encode((object)array("results" => "no exist"));

                        } else {

                            if ($t - 1 == 0) {

                                $images->results[$t - 1]['firstOne'] = true;

                            } else {

                                $images->results[$t - 1]['firstOne'] = false;
                            }

                            if($t == (count($images->results[$t]) - 1)){

                                $images->results[$t - 1]['lastOne'] = true;
                            }else{
                                $images->results[$t- 1]['lastOne'] = false;
                            }

                            header("Content-type: application/json");
                            echo json_encode((object)array("results" => $images->results[$t - 1]));

                        }
                    }
                }
            }
        }
    }

    /**
     * @param $page
     * @param $count
     * @param $paramsForFilters
     * @return \Collections\GalleryCollection
     */
    private function pagination($page, $count)
    {

        $startIndex = $page * $count;
        $imagesRepo = GalleryRepository::create();

        $outputObject = $imagesRepo->pagination($startIndex, $count);


        return $outputObject;
    }

    /**
     * @param $categoriesArray
     * @param $filters
     * @param $page
     * @param $count
     * @return mixed
     */
    private function filteredImages($categoriesArray, $filters, $page, $count)
    {

        $startIndex = $page * $count;
        $filteredImages = GalleryRepository::create();

        $query = "SELECT g.id,g.source,g.title,g.description,g.post_date, cat.name as category_name, t.name as tag_name FROM gallery g
                  JOIN gallery_categories gc ON
                  gc.gallery_id = g.id
                  JOIN categories cat ON
                  cat.id = gc.category_id
                  JOIN gallery_tags gt ON
                  gt.gallery_id = g.id
                  JOIN tags t ON
                  t.id = gt.tag_id";

        $images = $filteredImages->customQueryForFiltering($query, $categoriesArray, $filters, $startIndex, $count);

        return $images;
    }

    /**
     * @param $categoriesArray
     * @param $filters
     * @param $page
     * @param $count
     * @return object
     */
    private function getFilteredGallery($categoriesArray, $filters, $page, $count)
    {

        $imageRepo = GalleryRepository::create();

        $imageRepo->join("gallery_categories", "gallery_id", "=", "id", null);
        $imageRepo->join("categories", "id", "=", "category_id", "gallery_categories");
        $imageRepo->join("gallery_tags", "gallery_id", "=", "id", null);
        $imageRepo->join("tags", "id", "=", "tag_id", "gallery_tags");

        foreach ($categoriesArray as $category) {

            $imageRepo->qor("categories.id", $category);
        }
        $imageRepo->endqor(true);

        foreach ($filters as $tag) {
            $imageRepo->qor("tags.id", $tag);
        }
        $imageRepo->endqor();

        $imageRepo->select(["gallery.id",
            "gallery.source",
            "gallery.title",
            "gallery.description",
            "gallery.post_date",
            "categories.name as category_name",
            "tags.name as tag_name,
            tags.nameBG as tag_name_bg"]);

        $objectCounter = $imageRepo->get(99999);
        $getedObject = $imageRepo->get($page, $count);
        $getedObject->countOfImages = count($objectCounter->results);

        for ($i = 0; $i < count($getedObject->results); $i++) {
            for ($k = $i + 1; $k < count($getedObject->results); $k++) {

                if ($getedObject->results[$i]['id'] == $getedObject->results[$k]['id']) {

                    $element = array_search($getedObject->results[$i], $getedObject->results);

                    array_splice($getedObject->results, $element, 1);
                }
            }
        }
        return $getedObject;
    }

    /**
     * @return mixed
     */
    private function getGroupNames()
    {

        $groups = TagCategoryRepository::create();

        $groups = $groups->findAll();
        $allGroupsData = $groups->getObject();

        foreach ($allGroupsData->results as $group) {
            $group->elements = [];
        }
        return $allGroupsData->results;
    }
}