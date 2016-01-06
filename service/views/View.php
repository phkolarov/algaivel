<?php
namespace service\views;

class View
{

    public static $controllerName;
    public static $actionName;

    //if needed
    public static $viewBag = [];


    public static function make()
    {
        $args = func_get_args();

        if(count($args) == 2){
            self::loadViewAndModel($args[0],$args[1]);
        }
        else if(count($args) == 1){
            self::loadOnlyModel($args[0]);
        }else if(count($args) == 0){
            self::loadViewOnly();
        }
    }


    private static function loadViewAndModel($view,$model){
        require 'views'
            .DIRECTORY_SEPARATOR
            .$view
            .'.php';

    }

    private static function loadOnlyModel($model){

        require 'views'
            .DIRECTORY_SEPARATOR
            .self::$controllerName
            .DIRECTORY_SEPARATOR
            .self::$actionName
            .'.php';

    }

    private static function loadViewOnly(){

        var_dump(self::$controllerName);
        require 'views'
            .DIRECTORY_SEPARATOR
            .self::$controllerName
            .DIRECTORY_SEPARATOR
            .self::$actionName
            .'.php';
    }
}