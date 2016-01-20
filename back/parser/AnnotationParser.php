<?php



namespace parser;

    class AnnotationParser{

            static function CheckForAnnotation($controller,$action){

                $className = ucfirst($controller."Controller");
                $fullClassName = "controllers\\defaultControllers". '\\'. $className;
                $fullFilePath = "controllers\\defaultControllers\\".$className . ".php";

                if(file_exists($fullFilePath)){

                    require_once $fullFilePath;

                    $currentClass = new $fullClassName;
                    $reflection = new \ReflectionClass($currentClass);

                    $method = $reflection->getMethod($action);

                    $annotations = $method->getDocComment();
                    self::AuthorizeChecker($annotations);
                    self::RequestChecker($annotations);
                }
            }


            static function AuthorizeChecker($docBLock)
            {
                if (strpos($docBLock, "@Authorize")) {

                    if(!isset($_COOKIE['session'])){

                        header('Content-Type: application/json');
                        echo json_encode((object)array("error" => "You're not authorized!"));
                        die;
                    }
                }
            }

            static function RequestChecker($docBLock){

                if(strpos($docBLock,"@GET")){

                   if($_SERVER['REQUEST_METHOD'] != "GET"){
                       header('Content-Type: application/json');
                       echo json_encode((object)array("error" => "Invalid request!"));
                       die;
                   }
                }
                if(strpos($docBLock,"@POST")){

                    if($_SERVER['REQUEST_METHOD'] != "POST"){
                        header('Content-Type: application/json');
                        echo json_encode((object)array("error" => "Invalid request!"));
                        die;
                    }
                }
                if(strpos($docBLock,"@PUT")){

                    if($_SERVER['REQUEST_METHOD'] != "PUT"){
                        header('Content-Type: application/json');
                        echo json_encode((object)array("error" => "Invalid request!"));
                        die;
                    }
                }
                if(strpos($docBLock,"@DELETE")){

                    if($_SERVER['REQUEST_METHOD'] != "DELETE"){
                        header('Content-Type: application/json');
                        echo json_encode((object)array("error" => "Invalid request!"));
                        die;
                    }
                }

            }


    }