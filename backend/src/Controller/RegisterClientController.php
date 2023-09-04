<?php
namespace App\Controller;

use SoapFault;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\SoapClientService;

/**
 * Class RegisterClientController
 * @package App\Controller
 */
#[Route(path: "/api/", name: "api_")]
class RegisterClientController {

    private $soapClient;

    public function __construct(SoapClientService $soapClient) {
        $this->soapClient = $soapClient;
    }

    #[Route("registerclient", name: "registerclient", methods: ["POST"])]
    public function registerclient(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), TRUE);

        if (empty($data['name']) || empty($data['document']) || empty($data['mail']) || empty($data['phone']) ) {
          throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        try {
          $this->soapClient->init();
          $response = $this->soapClient->instance->registerClient([
            'document' => $data['document'],
            'mail' => $data['mail'],
            'phone' => $data['phone'],
            'name' => $data['name'],
          ]);

          $rawResult = $this->soapClient->instance->__getLastResponse();
          $x = $this->soapClient->XML2Array($rawResult);
          $code = $x["SOAP-ENV_Body"]["ns1_registerClientResponse"]["return"]["item"][0]["value"] ?? 0;
          $message = $x["SOAP-ENV_Body"]["ns1_registerClientResponse"]["return"]["item"][1]["value"] ?? 'unknown';
          if ($code == 200) {
            $code = Response::HTTP_CREATED;
          }

          $response = [
            'code' => $code,
            'message' => $message,
          ];

          //$xml = simplexml_load_string($rawResult);
          //$xml->registerXPathNamespace("soap", "http://www.w3.org/2003/05/soap-envelope");
          //$result = $xml->xpath('//soap:Body');

        }
        catch (SoapFault $e) {
          $code = $e->getCode();
          $response = [
            'code' => $code,
            'message' => $e->getMessage(),
          ];
        }

        return new JsonResponse($response, $code);
    }

}
