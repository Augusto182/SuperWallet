<?php
namespace App\Controller;

use SoapFault;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Service\SoapClientService;

/**
 * Class CreateOrderController
 * @package App\Controller
 */
#[Route(path: "/api/", name: "api_")]
class CreateOrderController {

    private $soapClient;
    private $requestStack;
    private $mailer;

    public function __construct(
      SoapClientService $soapClient,
      RequestStack $requestStack,
      MailerInterface $mailer) {
        $this->soapClient = $soapClient;
        $this->requestStack = $requestStack;
        $this->mailer = $mailer;
    }

    #[Route("createorder", name: "createorder", methods: ["POST"])]
    public function createorder(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), TRUE);

        if (empty($data['phone']) || empty($data['document']) || empty($data['value']) || empty($data['description']) ) {
          throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        try {
          $session = $this->requestStack->getSession();
          $session->start();
          $session_id = $session->getId();
          $this->soapClient->init();
          $response = $this->soapClient->instance->createOrder([
            'document' => $data['document'],
            'phone' => $data['phone'],
            'value' => $data['value'],
            'description' => $data['description'],
            'session' => $session_id,
          ]);

          $response = $this->soapClient->getResponse('createOrder');
          $response['session'] = $session_id;
          $code = $response['code'] ?? 500;

          $response['mail_sent'] = $this->sendMail([
            'mail' => $response['mail'],
            'token' => $response['token'],
          ]);
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

    /**
     * Send Mail
     */
    private function sendMail($data) {
      $to = $data['mail'];
      $subject = "Superwallet payment confirmation";
      $txt = "Superwallet payment confirmation.\r\nToken: " . $data['token'];
      $headers = "From: augusto@sucorreo.org";
      //mail($to,$subject,$txt,$headers);    
      $email = (new Email())
          ->from('augusto@sucorreo.org')
          ->to($to)
          ->subject($subject)
          ->text($txt);
      
      $r = TRUE;
      try {
        $this->mailer->send($email);
      }
      catch (\Exception $e) {
        $r = FALSE;
      }
      return $r;
    }

}
