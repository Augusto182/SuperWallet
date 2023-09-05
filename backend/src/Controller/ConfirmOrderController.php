<?php
namespace App\Controller;

use SoapFault;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\SoapClientService;

/**
 * Class ConfirmOrderController
 * @package App\Controller
 */
#[Route(path: "/api/", name: "api_")]
class ConfirmOrderController {

    private $soapClient;

    public function __construct(SoapClientService $soapClient) {
        $this->soapClient = $soapClient;
    }

    #[Route("confirmorder", name: "confirmorder", methods: ["POST"])]
    public function confirmorder(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), TRUE);

        if (empty($data['token']) || empty($data['session'])) {
          throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        try {
          $this->soapClient->init();
          $response = $this->soapClient->instance->createOrder([
            'token' => $data['token'],
            'session' => 'session',
          ]);

          $response = $this->soapClient->getResponse('createOrder');
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
