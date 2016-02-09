<?php

namespace controllers\defaultControllers;

use Models\Article;
use Repositories\ArticlesRepository;


class ArticleController
{


    public function index($parameters)
    {

        $page = $parameters[0];
        $year = null;
        $articleRepo = ArticlesRepository::create();

        if (isset($parameters[1])) {

            $year = $parameters[1];
        }

        if ($year == null) {


            $articles = $articleRepo->orderByDescending('post_date')->findAll();

            $publicArticlesObject = $articles->getObject();
            $allArticlesCount = count($publicArticlesObject->results);

            $articles = $this->pagination($page, 9);
            $articlesObject = $articles->getObject();
            $articlesObject->countOfImages = $allArticlesCount;

            header("Content-Type: application/json");
            echo json_encode($articlesObject);

        } else {

            $queryYear = (int)$year;

            $articles = $this->pagination($page, 9,"year(post_date)", $queryYear);
            $outputArticles = $articles->getObject();
            header('Content-type: application/json');
            echo json_encode($outputArticles);


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
    private function pagination($page, $count,$column,$queryYear)
    {
        $startIndex = $page * $count;
        $articlesRepo = ArticlesRepository::create();
        $articlesRepo->customWhere($column,$queryYear);
        $articlesRepo->orderByDescending('post_date');
        $outputObject = $articlesRepo->pagination($startIndex, $count);

        return $outputObject;
    }


    public function getNewsPageCount($year = null)
    {

        $articleRepo = ArticlesRepository::create();


        $queryYear = (int)$year[0];
        $query = "year(post_date) = $queryYear";
        $articleRepo->customWhere("year(post_date)",$queryYear);
        $articleRepo->orderByDescending("post_date");

        $articles = $articleRepo->findAll();
        $publicArticlesObject = $articles->getObject();
        //var_dump($publicArticlesObject);
        $pageCount = count($publicArticlesObject->results);

        $pages = floor($pageCount / 9);

        if ($pages % 9 > 0) {

            $pages++;
        }


        if ($year != null) {

            header("Content-type: application/json");
            echo json_encode((object)array("results" => $pages));
        }
    }

    public function getCurrentArticle($parameters)
    {

        $id = $parameters[0];
        $articleRepo = ArticlesRepository::create();
        $articleRepo->filterById($id);
        $currentArticle = $articleRepo->findOne();

        if($currentArticle->getId() != null){

            $outPutArticleObjecgt =  $currentArticle->FullObjectGeter();

            header("Content-type: application/json");
            echo json_encode((object)array("results" => $outPutArticleObjecgt));
        }else{

            header("Content-type: application/json");
            echo json_encode((object)array("results" => "Not Found"));
        }

    }


}
