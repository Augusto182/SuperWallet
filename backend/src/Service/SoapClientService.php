<?php

namespace App\Service;

use SoapClient;

class SoapClientService {

  public $instance;

  const SOAP_URL = 'http://api.superwallet.loc';

  /**
   * Init
   */
  public function init() {

    $wsdl = self::SOAP_URL . '/soap/soap_server.wsdl';
    $this->instance = new SoapClient($wsdl,[
      'cache_wsdl' => WSDL_CACHE_NONE,
      'location' => self::SOAP_URL . '/soap/soap_server.php',
      'trace' => TRUE,
    ]);
  }
  
  /**
   * getResponse
   */
  public function getResponse($operation) {
    $response = [];
    $tag = "ns1_" . $operation . "Response";
    $rawResult = $this->instance->__getLastResponse();
    $x = $this->XML2Array($rawResult);
    foreach ($x["SOAP-ENV_Body"][$tag]["return"]["item"] as $item) {
      $response[$item['key']] = $item['value'];
    }
    return $response;
  }

  /**
   * XML2Array
   */
  public function XML2Array($xml) {
    $plainXML = $this->mungXML( trim($xml) );
    $arrayResult = json_decode(json_encode(SimpleXML_Load_String($plainXML, 'SimpleXMLElement', LIBXML_NOCDATA)), TRUE);
    return $arrayResult;
  }

  /**
   * mungXML
   */
  private function mungXML($xml) {
    $obj = SimpleXML_Load_String($xml);
    if ($obj === FALSE) return $xml;

    // GET NAMESPACES, IF ANY
    $nss = $obj->getNamespaces(TRUE);
    if (empty($nss)) return $xml;

    // CHANGE ns: INTO ns_
    $nsm = array_keys($nss);
    foreach ($nsm as $key)
    {
        // A REGULAR EXPRESSION TO MUNG THE XML
        $rgx
        = '#'               // REGEX DELIMITER
        . '('               // GROUP PATTERN 1
        . '\<'              // LOCATE A LEFT WICKET
        . '/?'              // MAYBE FOLLOWED BY A SLASH
        . preg_quote($key)  // THE NAMESPACE
        . ')'               // END GROUP PATTERN
        . '('               // GROUP PATTERN 2
        . ':{1}'            // A COLON (EXACTLY ONE)
        . ')'               // END GROUP PATTERN
        . '#'               // REGEX DELIMITER
        ;
        // INSERT THE UNDERSCORE INTO THE TAG NAME
        $rep
        = '$1'          // BACKREFERENCE TO GROUP 1
        . '_'           // LITERAL UNDERSCORE IN PLACE OF GROUP 2
        ;
        // PERFORM THE REPLACEMENT
        $xml =  preg_replace($rgx, $rep, $xml);
    }

    return $xml;

  } // End :: mungXML()

}