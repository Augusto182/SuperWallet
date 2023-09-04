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
 * Class LoadWalletController
 * @package App\Controller
 */
#[Route(path: "/api/", name: "api_")]
class LoadWalletController {

    private $soapClient;

    public function __construct(SoapClientService $soapClient) {
        $this->soapClient = $soapClient;
    }

    #[Route("loadwallet", name: "loadwallet", methods: ["POST"])]
    public function loadwallet(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), TRUE);

        if (empty($data['document']) || empty($data['phone']) ) {
          throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        try {
          $this->soapClient->init();
          $response = $this->soapClient->instance->loadwallet([
            'document' => $data['document'],
            'phone' => $data['phone'],
            'value' => $data['value'],
          ]);

          $rawResult = $this->soapClient->instance->__getLastResponse();
          $x = $this->soapClient->XML2Array($rawResult);
          $code = $x["SOAP-ENV_Body"]["ns1_loadWalletResponse"]["return"]["item"][0]["value"] ?? 0;
          $message = $x["SOAP-ENV_Body"]["ns1_loadWalletResponse"]["return"]["item"][1]["value"] ?? 'unknown';
          if ($code == 200) {
            $code = Response::HTTP_CREATED;
          }

          $response = [
            'code' => $code,
            'message' => $message,
          ];
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
