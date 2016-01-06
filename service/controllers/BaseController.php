<?php


namespace controllers;


use parser\AnnotationParser;

class BaseController
{


    public static function ControllerSeeker($ctrl, $act, $param)
    {


        $controller = $ctrl;
        $action = $act;
        $parameters = $param;

        $controllerPath = "controllers\\defaultControllers\\" . ucfirst($controller) . "Controller";

        AnnotationParser::CheckForAnnotation($ctrl, $act);

        $currentController = new $controllerPath();

        if (method_exists($currentController, $action)) {

           call_user_func_array(array($currentController, $action), array($parameters));

        }
    }

}