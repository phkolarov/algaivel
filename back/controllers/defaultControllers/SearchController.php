<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 4.2.2016 г.
 * Time: 13:29 ч.
 */

namespace controllers\defaultControllers;


use Repositories\ArticlesRepository;
use Repositories\GalleryRepository;

class SearchController
{


    public function searchArticles($parameters)
    {
        $page = $parameters[0];
        $context = $parameters[1];
        $language = $parameters[2];

        if ($language == "EN") {
            $foundedArticles = $this->articlesSearch($page, $context);

            header("Content-type: application/json");
            echo json_encode($foundedArticles);
            die();

        } else if ($language == "BG") {
//            var_dump($context);
            $foundedArticles = $this->articlesSearchBG($page, $context);

            header("Content-type: application/json");
            echo json_encode($foundedArticles);
            die();
        }
    }


    public function searchImages($parameters)
    {
        $page = $parameters[0];
        $context = $parameters[1];
        $language = $parameters[2];

        if ($language == "EN") {
            $foundedImages = $this->imagesSearch($page, $context);

            header("Content-type: application/json");
            echo json_encode($foundedImages);
            die();

        } else if ($language == "BG") {
            $foundedImages = $this->imagesSearchBG($page, $context);
            header("Content-type: application/json");
            echo json_encode($foundedImages);
            die();
        }
    }


    private function articlesSearch($page, $context)
    {

        $articlesRepo = ArticlesRepository::create();
        $articleIndex = $page * 9;

        if (!is_numeric($page)) {
            throw new \Exception('Invalid argument');
        }

        $articlesRepo->customOr('title', $context);
        $articlesRepo->customOr('content', $context);
        $articles = $articlesRepo->pagination($articleIndex, 9);
        $articlesCountObject = $articlesRepo->pagination(0, 99);

        $outPutObject = $articles->getObject();
        $pages = $this->pageCounter($articlesCountObject->getObject(),9);
        $outPutObject->pageCount = $pages;

        return $outPutObject;
    }

    private function articlesSearchBG($page, $context)
    {

        $articlesRepo = ArticlesRepository::create();
        $articleIndex = $page * 9;
        if (!is_numeric($page)) {
            throw new \Exception('Invalid argument');
        }

        $articlesRepo->customOr('titleBG', $context);
        $articlesRepo->customOr('contentBG', $context);
        $articles = $articlesRepo->pagination($articleIndex, 9);
        $articlesCountObject = $articlesRepo->pagination(0,99);

        $outPutObject = $articles->getObject();
        $pages = $this->pageCounter($articlesCountObject->getObject(),9);
        $outPutObject->pageCount = $pages;

        return $outPutObject;
    }

    private function imagesSearch($page, $context)
    {

        $imageRepo = GalleryRepository::create();
        $imageIndex = $page * 9;

        if (!is_numeric($page)) {
            throw new \Exception('Invalid argument');
        }

        $imageRepo->customOr("description", $context);
        $imageRepo->customOr("title", $context);
        $images = $imageRepo->pagination($imageIndex, 9);

        $galleryRepoCounter = GalleryRepository::create();
        $galleryRepoCounter->customOr('description', $context);
        $galleryRepoCounter->customOr('title', $context);
        $imagesCountObject = $galleryRepoCounter->pagination(0, 99);

        $outPutObject = $imagesCountObject->getObject();
        $pages = $this->pageCounter($imagesCountObject->getObject(),9);
        $outPutObject->pageCount = $pages;

        return $outPutObject;
    }

    private function imagesSearchBG($page, $context)
    {

        $imageRepo = GalleryRepository::create();
        $imageIndex = $page * 9;

        if (!is_numeric($page)) {
            throw new \Exception('Invalid argument');
        }

        $imageRepo->customOr("titleBG", $context);
        $imageRepo->customOr("descriptionBG", $context);
        $images = $imageRepo->pagination($imageIndex, 9);

        $galleryRepoCounter = GalleryRepository::create();
        $galleryRepoCounter->customOr('descriptionBG', $context);
        $galleryRepoCounter->customOr('titleBG', $context);
        $imagesCountObject = $galleryRepoCounter->pagination(0, 99);

        $outPutObject = $images->getObject();
        $pages = $this->pageCounter($imagesCountObject->getObject(),9);
        $outPutObject->pageCount = $pages;

        return $outPutObject;

    }


    private function pageCounter($object,$countPerPage){

        $count  = floor(count($object->results)/$countPerPage);

        if(count($object->results)%$countPerPage > 0){
            $count++;
        }
        return $count;
    }
}