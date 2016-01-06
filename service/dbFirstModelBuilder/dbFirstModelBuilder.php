<?php

namespace dbFirstModelBuilder;

ini_set('display_errors', 1);
include 'repositories_create.php';
include "collections_create.php";
use PDO;

class dbFirstModelBuilder{


public static function createdbFirstModels()
{


    $pdo = new PDO("mysql:host=localhost;dbname=akatskydb", 'root', '');
    $tables = array_map(function ($t) {
        return $t[0];
    },
        $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_NUM));

    foreach ($tables as $tableName) {
        $columns =
            array_map(function ($c) {
                return $c['Field'];
            },
                $pdo->query("SHOW COLUMNS FROM $tableName")->fetchAll(PDO::FETCH_ASSOC));
        $repositoryNameSplitted = explode("_", $tableName);
        for ($i = 0; $i < count($repositoryNameSplitted); $i++) {
            $repositoryNameSplitted[$i] = ucfirst($repositoryNameSplitted[$i]);
        }
        $repositoryName = implode("", $repositoryNameSplitted);
        $model = $repositoryName[strlen($repositoryName) - 1] == 's' ? substr($repositoryName, 0, strlen($repositoryName) - 1) : $repositoryName;
        $repositoryName .= "Repository";
        createRepositories($repositoryName, $model, $tableName, $columns);
        $output = "";
        $output .= self::generateClassInfo($model);
        $output .= self::generateConstants($model, $tableName, $columns);
        $output .= self::generateFields($model, $tableName, $columns);
        $output .= self::generateConstructor($model, $tableName, $columns);
        $output .= self::generateGettersAndSetters($model, $tableName, $columns);
        $output .= self::generateObjectGeter($columns);
        $output .= "}";
        $modelFile = fopen("Models/" . $model . '.php', 'w');
        fwrite($modelFile, $output);
        $collectionsOutput = create_collection($model);
        $collectionFile = fopen('Collections/' . $model . 'Collection.php', 'w');
        fwrite($collectionFile, $collectionsOutput);
    }
}
    static function generateClassInfo($model)
    {
        $output = "";
        $output = <<<KUF
<?php
namespace Models;
class $model
{
KUF;
        return $output;
    }

    static function generateFields($model, $tableName, $columns)
    {
        $output = "";
        foreach ($columns as $column) {
            $output .= "\n\tprivate $" . $column . ';';
        }
        return $output . "\n";
    }

    static function generateConstructor($model, $tableName, $columns)
    {
        $output = "";
        $signature = "";
        foreach ($columns as $column) {
            if ($column != "id") {
                $signature .= '$' . $column . ", ";
            }
        }
        $signature .= '$id = null';
        $output .= "\n\tpublic function __construct($signature)";
        $output .= "\n\t{";
        foreach ($columns as $column) {
            $output .= "\n\t\t" . '$this->set' . ucfirst($column) . '($' . $column . ');';
        }
        $output .= "\n\t}";
        return $output . "\n";
    }

    static function generateGettersAndSetters($model, $tableName, $columns)
    {
        /*
         *     /**
             * @return mixed
            public function getId()
            {
                return $this->id;
            }
         */
        $output = "";
        foreach ($columns as $column) {
            $output .= "\n\t/**";
            $output .= "\n\t* @return mixed";
            $output .= "\n\t*/";
            $output .= "\n\tpublic function get" . ucfirst($column) . '()';
            $output .= "\n\t{";
            $output .= "\n\t\treturn" . ' $this->' . $column . ';';
            $output .= "\n\t}";
            $output .= "\n";
            $output .= "\n\t/**";
            $output .= "\n\t* @param" . ' $' . $column;
            $output .= "\n\t* @return" . ' $this';
            $output .= "\n\t*/";
            $output .= "\n\tpublic function set" . ucfirst($column) . '($' . $column . ')';
            $output .= "\n\t{";
            $output .= "\n\t\t" . '$this->' . $column . ' = $' . $column . ';';
            $output .= "\n\t\t";
            $output .= "\n\t\treturn" . ' $this;';
            $output .= "\n\t}";
            $output .= "\n\n";
        }
        return $output;
    }

    static function generateConstants($model, $tableName, $columns)
    {
        //    const COL_USERNAME = 'username';
        $output = "";
        foreach ($columns as $column) {
            $output .= "\n\tconst COL_" . strtoupper($column) . ' = \'' . $column . '\';';
        }
        return $output . "\n";
    }

    static  function generateObjectGeter($columns){

            $output = "";
            $output .= "\n\t public function FullObjectGeter()";
            $output .= "\n\t{\n\t" . "\$object = (object)array(";

        foreach ($columns as $column) {

                   $output .= "\n\t\t\"$column\"" . " => \$this->". $column.", ";
                }
        $output .= "\n\t);";

        $output .= "\n\t return \$object;";

        $output .="\n\t}";
        return $output;
    }



}