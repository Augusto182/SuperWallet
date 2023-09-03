<?php

// Create a SOAP client
try {

  $wsdl = 'http://api.superwallet.loc/soap/soap_server.wsdl';
  $client = new SoapClient($wsdl,[
    'cache_wsdl' => WSDL_CACHE_NONE,
    'location' => 'http://api.superwallet.loc/soap/soap_server.php',
    'trace' => TRUE,
  ]);

  // Get the SOAP response headers
  // $responseHeaders = $client->__getLastResponseHeaders();
  // Get the SOAP response content
  // $responseContent = $client->__getLastResponse();

  // Call SOAP methods using the client
  $response = $client->registerClient([
    'document' => 123456789,
    'mail' => 'client@example.com',
    'phone' => 1234567890,
    'name' => 'John Doe',
  ]);

  $rawResult = $client->__getLastResponse();

  // Process the SOAP response
  print_r($response);
}
catch (SoapFault $fault) {
  // Handle SOAP fault (error)
  echo 'SOAP Fault: ' . $fault->getMessage();
}