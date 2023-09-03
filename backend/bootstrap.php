<?php
// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . '/vendor/autoload.php';
$doctrineConfig = require_once __DIR__ . '/config/doctrine.php';
$entityPaths = [__DIR__ . '/src/Entity/'];
// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: $entityPaths,
    isDevMode: $doctrineConfig['dev_mode'],
);

// configuring the database connection
$connection = DriverManager::getConnection($doctrineConfig['db'], $config);

// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);

// Create the SuperWalletSOAP object
// $superWalletSoap = new SuperWalletSOAP();