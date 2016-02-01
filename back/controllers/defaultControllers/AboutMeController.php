<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 28.1.2016 г.
 * Time: 10:33 ч.
 */

namespace controllers\defaultControllers;


use Repositories\AboutmeinfotableRepository;
use Repositories\FineartRepository;

class AboutMeController
{


    /**
     * @GET
     */
    public function index(){



        $aboutMeRepo = AboutmeinfotableRepository::create();
        $aboutMePrimeElement = $aboutMeRepo->findOne();

        $aboutMeOutputObject = $aboutMePrimeElement->FullObjectGeter();

        header("Content-type: application/json");
        echo json_encode((object)array('results'=> $aboutMeOutputObject));

    }
}