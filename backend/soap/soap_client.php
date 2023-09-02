<?php

// Create a SOAP client
try {

  // Specify the URL or local path to the WSDL file
  $wsdl = 'http://api.superwallet.loc/soap/soap_server.wsdl';

  // Create a SOAP client with the WSDL file
  $client = new SoapClient($wsdl);

  // Call SOAP methods using the client
  $response = $client->registerClient([
    'document' => 123456789,
    'mail' => 'client@example.com',
    'phone' => 1234567890,
    'name' => 'John Doe',
  ]);

  // Process the SOAP response
  print_r($response);

  // Call the registerClient method
  //$response = $client->__soapCall('registerClient', [$params]);
}
catch (SoapFault $fault) {
  // Handle SOAP fault (error)
  echo 'SOAP Fault: ' . $fault->getMessage();
}