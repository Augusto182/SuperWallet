<?php
// File: soap_server.php

// Define the SOAP server
$options = [
    'uri' => 'http://localhost/soap_server.php'
];
$server = new SoapServer(null, $options);

// Define the service function
function sayHello($name) {
    return "Hello, $name!";
}

// Register the service function
$server->addFunction('sayHello');

// Handle incoming SOAP requests
$server->handle();
?>
