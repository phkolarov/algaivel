<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 8.12.2015 г.
 * Time: 13:38 ч.
 */


include("controllers/BaseController.php");
include("views/View.php");

use controllers\BaseController;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class app
{


    public static $uri;
    public static $controller;
    public static $action;
    public static $parameters;
    protected static $applicationUser;

    // THe constructor explore URI to controller,action and parameters if exist and
    //set it to ControllerSeeker hwo find the current controller;

    public function __construct($uri){

        $this::$uri = $uri;
        $requestUri = explode("/", $uri);

        $controller =  array_shift($requestUri);
        $this::$controller = ($controller == "index.php") ? "home" : $controller;

        $action = array_shift($requestUri);
        $this::$action = ($action == "") || ($action == null)? "index" : $action;
        $this::$parameters = $requestUri;
    }

    public function run(){

        BaseController::ControllerSeeker(self::$controller,self::$action,self::$parameters);
    }
}