
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("Autoloader/Autoloader.php");


\Autoloader\Autoloader::init();

$dbFirstModelBuilder = new \dbFirstModelBuilder\dbFirstModelBuilder();

$dbFirstModelBuilder->createdbFirstModels();

Core\Database::setInstance(
    \Config\DatabaseConfig::DB_INSTANCE,
    \Config\DatabaseConfig::DB_DRIVER,
    \Config\DatabaseConfig::DB_USER,
    \Config\DatabaseConfig::DB_PASS,
    \Config\DatabaseConfig::DB_NAME,
    \Config\DatabaseConfig::DB_HOST
);

$app = new app($_GET['uri']);

$app->run(); ?>

