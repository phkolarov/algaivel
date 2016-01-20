<?php

namespace Autoloader;

class Autoloader
{
    public static function init()
    {
        spl_autoload_register(function ($class) {

            $pathParams = explode("\\", $class);
            $path = implode(DIRECTORY_SEPARATOR, $pathParams);
            require_once $path . '.php';

        });
    }
}