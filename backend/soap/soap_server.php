<?php
// SuperWalletSOAP

require __DIR__ . '/../bootstrap.php';
use SuperWallet\Service\SuperWalletSOAP;

$wsdl = 'http://api.superwallet.loc/soap/soap_server.wsdl';

// Create a SOAP server with SuperWalletSOAP
// $server = new SuperWalletSOAP($wsdl, ['uri' => 'http://api.superwallet.loc/soap/soap_server.php']);
$server = new SoapServer(NULL, ['uri' => 'http://api.superwallet.loc/soap/soap_server.php']);
// $server = new SoapServer('http://api.superwallet.loc/soap/soap_server.wsdl');

// Instantiate the SuperWalletSOAP class with the EntityManager
$superWalletSoap = new SuperWalletSOAP($entityManager);

// Set the class to handle SOAP requests
$server->setObject($superWalletSoap);
// Set the SOAP class for the server
// $server->setClass('SuperWalletSOAP');

// Handle SOAP requests
$server->handle();