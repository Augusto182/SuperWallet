<?php

namespace SuperWallet\Service;

use SuperWallet\Entity\Client;
use SuperWallet\Entity\Wallet;
use SuperWallet\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

class SuperWalletSOAP {

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * Register a new client.
     *
     * @param int $document
     * @param string $mail
     * @param int $phone
     * @param string $name
     *
     * @return array
     *   Response array with keys:
     *   - 'code' (int): Response code.
     *   - 'message' (string): Response message.
     */
    public function registerClient($document, $mail, $phone, $name) {
        try {
          // Create a new Client entity
          $client = new Client();
          $client->setDocument($document);
          $client->setMail($mail);
          $client->setPhone($phone);
          $client->setName($name);
  
          // Persist the Client entity to the database
          $this->entityManager->persist($client);
          $this->entityManager->flush();
            
          return [
            'code' => 200,
            'message' => 'Client registered successfully.',
          ];
        }
        catch (\Exception $e) {
          
          return [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
          ];
        }
      }
  
      /**
       * Load funds into a wallet.
       *
       * @param int $document
       * @param int $phone
       * @param float $value
       *
       * @return array
       *   Response array with keys:
       *   - 'code' (int): Response code.
       *   - 'message' (string): Response message.
       */
      public function loadWallet($document, $phone, $value) {
        try {
          $client = $this->clientExist($document, $phone);
          if ($client) {
            $old_value = 0;
            $wallet = $this->walletExist($client->getId());
            if (!$wallet) {
              // Create a new Wallet entity
              $wallet = new Wallet();
              $wallet->setClient($client);
            }
            else {
              $old_value = $wallet->getValue();
            }
            $wallet->setValue($value + $old_value);
            $this->entityManager->persist($wallet);
            $this->entityManager->flush();
            return [
              'code' => 200,
              'message' => 'Wallet successfully recharged.',
            ];
          }
          else {
            throw new \Exception('Client not found.', 404);
          }

          
        }
        catch (\Exception $e) {
          
          return [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
          ];
        }
      }
  
      /**
       * Check the balance of a wallet.
       *
       * @param int $document
       * @param int $phone
       *
       * @return array
       *   Response array with keys:
       *   - 'content' (string): Balance content.
       *   - 'code' (int): Response code.
       *   - 'message' (string): Response message.
       */
      public function checkBalance($document, $phone) {
        try {
          $client = $this->clientExist($document, $phone);
          if ($client) {
            $value = 0;
            $wallet = $this->walletExist($client->getId());
            if ($wallet) {
              $value = $wallet->getValue();
            }
            return [
              'balance' => $value,
              'code' => 200,
              'message' => 'Balance successfully readed.',
            ];
          }
          else {
            throw new \Exception('Client not found.', 404);
          }

          
        }
        catch (\Exception $e) {
          
          return [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
          ];
        }
      }
  
      /**
       * Create a new order.
       *
       * @param int $document
       * @param int $phone
       * @param float $value
       * @param string $description
       * @param string $session
       *
       * @return array
       *   Response array with keys:
       *   - 'token' (int): Order token.
       *   - 'code' (int): Response code.
       *   - 'message' (string): Response message.
       */
      public function createOrder($document, $phone, $value, $description, $session) {
        try {
          $client = $this->clientExist($document, $phone);
          if ($client) {
            $balance = 0;
            $wallet = $this->walletExist($client->getId());
            if ($wallet) {
              $balance = $wallet->getValue();
            }
            if ($balance < $value) {
              throw new \Exception('Insufficient Balance.', 400);
            }
            // Create a new Order entity
            $token = $this->generateRandomSixDigitString();
            $order = new Order();
            $order->setWallet($wallet);
            $order->setClient($client);
            $order->setSession($session);
            $order->setToken($token);
            $order->setValue($value);
            $order->setStatus('pending');
            $order->setDescription($description);

            // Persist the Client entity to the database
            $this->entityManager->persist($client);
            $this->entityManager->flush();

            return [
              'token' => $token,
              'code' => 200,
              'message' => 'Payment order created.',
            ];
          }
          else {
            throw new \Exception('Client not found.', 404);
          }
        }
        catch (\Exception $e) {
          
          return [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
          ];
        }
      }
  
      /**
       * Confirm an order.
       *
       * @param int $token
       * @param string $session
       *
       * @return array
       *   Response array with keys:
       *   - 'code' (int): Response code.
       *   - 'message' (string): Response message.
       */
      public function confirmOrder($token, $session) {
          // Implement order confirmation logic here.
          // Return the response as an array.
      }

      /**
       * Check client exist.
       *
       * @param int $document
       * @param int $phone
       *
       * @return mixed
       */
      public function clientExist($document, $phone) {
        $clientRepository = $this->entityManager->getRepository(Client::class);
        $client = $clientRepository->findOneBy([
          'document' => $document,
          'phone' => $phone,
        ]);
        $response = $client instanceof Client ? $client : FALSE;
        return $client;
      }

      /**
       * Check wallet exist.
       *
       * @param int $clientId
       *
       * @return mixed
       */
      public function walletExist($clientId) {
        $walletRepository = $this->entityManager->getRepository(Wallet::class);
        $wallet = $walletRepository->findOneBy([
          'client_id' => $clientId,
        ]);
        $response = $wallet instanceof Wallet ? $wallet : FALSE;
        return $wallet;
      }

      /**
       * Generate Random Six Digit String
       */
      public function generateRandomSixDigitString(): string {
        $min = 100000;
        $max = 999999;
        $randomNumber = mt_rand($min, $max);
        return (string) $randomNumber;
      }

      /**
       * Check valid token order.
       *
       * @param int $clientId
       *
       * @return mixed
       */
      // public function validToken($clientId) {
      //   $walletRepository = $this->entityManager->getRepository(Wallet::class);
      //   $wallet = $walletRepository->findOneBy([
      //     'client_id' => $clientId,
      //   ]);
      //   $response = $wallet instanceof Wallet ? $wallet : FALSE;
      //   return $wallet;
      // }
}