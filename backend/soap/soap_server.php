<?php
// SuperWalletSOAP

require __DIR__ . '/../bootstrap.php';
use SuperWallet\Service\SuperWalletSOAP;

const SOAP_URL = 'http://api.superwallet.loc';

$wsdl = SOAP_URL . '/soap/soap_server.wsdl';

// Create a SOAP server with SuperWalletSOAP
$server = new SoapServer(NULL, ['uri' => SOAP_URL . '/soap/soap_server.php']);
// Instantiate the SuperWalletSOAP class with the EntityManager
$superWalletSoap = new SuperWalletSOAP($entityManager);

// Set the class to handle SOAP requests
$server->setObject($superWalletSoap);

// Handle SOAP requests
$server->handle();