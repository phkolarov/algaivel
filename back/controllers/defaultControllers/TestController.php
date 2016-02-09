<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 3.2.2016 г.
 * Time: 14:15 ч.
 */

namespace controllers\defaultControllers;


class TestController
{


    /**
     * @POST
     */
    public function index(){


        var_dump($_POST);
    }
}