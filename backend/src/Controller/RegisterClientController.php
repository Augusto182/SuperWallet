<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegisterClientController
 * @package App\Controller
 * 
 * @Route(path="/api/")
 */
#[Route(path: "/api/", name: "api_")]
class RegisterClientController {

    public function __construct() {

    }


    /**
     * @Route("registerclient", name="registerclient", methods={"POST"})
     */
    #[Route("registerclient", name: "registerclient", methods: ["POST"])]
    public function registerclient(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), TRUE);
        $name = $data['name'];
        if (empty($name)) {
          throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        return new JsonResponse([
            'code' => 200,
            'message' => 'Client registered successfully.',
        ], Response::HTTP_CREATED);
    }

}
