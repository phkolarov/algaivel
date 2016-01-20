<?php

namespace controllers\defaultControllers;

use Repositories\ArticlesRepository;


class ArticleController{


    public function index($parameters){

        $page = $parameters[0];
        $count = $parameters[1];



        if ($_SERVER['REQUEST_METHOD'] == "GET") {


            $articleRepo = ArticlesRepository::create();
            $articles = $articleRepo->orderByDescending('post_date')->findAll();

            $publicArticlesObject = $articles->getObject();
            $allArticlesCount = count($publicArticlesObject->results);

            $articles = $this->pagination($page, $count);
            $articlesObject = $articles->getObject();
            $articlesObject->countOfImages = $allArticlesCount;

            header("Content-Type: application/json");
            echo json_encode($articlesObject);

        }
//        else if ($_SERVER['REQUEST_METHOD'] == "POST") {
//
//            $parsedJSON = json_decode(file_get_contents('php://input'));
//            $groups = $parsedJSON->groups;
//            $filters = $parsedJSON->tags;
//
//            $images = $this->getFilteredGallery($groups, $filters, $page, $count);
//
//            header("Content-Type: application/json");
//            echo json_encode($images);
//        }



    }


    /**
     * @param $page
     * @param $count
     * @return \Collections\ArticleCollection
     */
    private function pagination($page, $count)
    {
        $startIndex = $page * $count;
        $articlesRepo = ArticlesRepository::create();
        $outputObject = $articlesRepo->pagination($startIndex, $count);

        return $outputObject;
    }


}
