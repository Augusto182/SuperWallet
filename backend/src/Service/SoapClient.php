<?php

namespace App\Service;

use SoapClient;

class SoapClientService {

  public $instance;

  public function init() {

    $wsdl = 'http://api.superwallet.loc/soap/soap_server.wsdl';
    $this->instance = new SoapClient($wsdl,[
      'cache_wsdl' => WSDL_CACHE_NONE,
      'location' => 'http://api.superwallet.loc/soap/soap_server.php',
      'trace' => TRUE,
    ]);
  }
  
}