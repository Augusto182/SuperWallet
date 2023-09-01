<?php
// backend/bootstrap.php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once 'vendor/autoload.php';
require_once __DIR__ . '/../config/doctrine.php';

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(
    [__DIR__."/src"],
    $isDevMode
);

$conn = [
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'user' => 'your_username',
    'password' => 'your_password',
    'dbname' => 'your_database',
];

$entityManager = EntityManager::create($conn, $config);