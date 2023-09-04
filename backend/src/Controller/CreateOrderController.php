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
 * Class CreateOrderController
 * @package App\Controller
 */
#[Route(path: "/api/", name: "api_")]
class CreateOrderController {

    private $soapClient;

    public function __construct(SoapClientService $soapClient) {
        $this->soapClient = $soapClient;
    }

    #[Route("createorder", name: "createorder", methods: ["POST"])]
    public function createorder(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), TRUE);

        if (empty($data['phone']) || empty($data['document']) || empty($data['value']) || empty($data['description']) ) {
          throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        try {
          $this->soapClient->init();
          $response = $this->soapClient->instance->createOrder([
            'document' => $data['document'],
            'phone' => $data['phone'],
            'value' => $data['value'],
            'description' => $data['description'],
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
