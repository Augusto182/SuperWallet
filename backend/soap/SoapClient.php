<?php
// File: soap_client.php

// Define the SOAP client
$options = [
    'uri' => 'http://localhost/soap_server.php'
];
$client = new SoapClient(null, $options);

// Call the remote service
$name = "John";
$response = $client->sayHello($name);

// Display the response
echo $response;
?>
