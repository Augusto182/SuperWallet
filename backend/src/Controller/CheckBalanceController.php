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
 * Class CheckBalanceController
 * @package App\Controller
 */
#[Route(path: "/api/", name: "api_")]
class CheckBalanceController {

    private $soapClient;

    public function __construct(SoapClientService $soapClient) {
        $this->soapClient = $soapClient;
    }

    #[Route("checkbalance", name: "checkbalance", methods: ["GET"])]
    public function checkbalance(Request $request): JsonResponse {
        $phone = $request->get('phone');
        $document = $request->get('document');

        if (empty($phone) || empty($document)) {
          throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        try {
          $this->soapClient->init();
          $response = $this->soapClient->instance->checkBalance([
            'document' => $document,
            'phone' => $phone,
          ]);
 
          $response = $this->soapClient->getResponse('checkBalance');
          $code = $response['code'] ?? 500;
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
