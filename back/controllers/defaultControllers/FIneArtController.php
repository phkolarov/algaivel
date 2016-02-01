<?php

namespace controllers\defaultControllers;



use Repositories\FineartRepository;

class FineArtController{

    /**
     * @GET
     */
        public function index(){

            $fineArtInfo = FineartRepository::create();
            $FineArtObject = $fineArtInfo->findOne();
            $fineArtOutputObject = $FineArtObject->FullObjectGeter();

            header("Content-type: application/json");
            echo json_encode((object)array("results" => $fineArtOutputObject));
        }
}