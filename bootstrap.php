<?php

require_once 'vendor/autoload.php';

use src\core\DatabaseConnector;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$dbInstance = DatabaseConnector::getInstance();
$conn = $dbInstance->getConnection();