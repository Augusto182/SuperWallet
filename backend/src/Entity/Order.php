<?php
// src/Entity/Order.php

namespace SuperWallet\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "order")]
class Order {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected $id;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    #[ORM\JoinColumn(name: "client_id", referencedColumnName: "id")]
    protected $clientId;

    #[ORM\ManyToOne(targetEntity: Wallet::class)]
    #[ORM\JoinColumn(name: "wallet_id", referencedColumnName: "id")]
    protected $walletId;

    #[ORM\Column(type: "string")]
    protected $session;

    #[ORM\Column(type: "string")]
    protected $token;

    #[ORM\Column(type: "string")]
    protected $description;

    #[ORM\Column(type: "float")]
    protected $value;

    #[ORM\Column(type: "integer")]
    protected $status;

    // Getters and setters for the above properties

    public function getId(): ?int {
        return $this->id;
    }

    public function getWallet(): ?Wallet {
        return $this->walletId;
    }

    public function setWallet(Wallet $walletId): self {
        $this->walletId = $walletId;

        return $this;
    }

    public function getSession(): ?string {
        return $this->session;
    }

    public function setSession(string $session): self {
        $this->session = $session;

        return $this;
    }

    public function getToken(): ?string {
        return $this->token;
    }

    public function setToken(string $token): self {
        $this->token = $token;

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;

        return $this;
    }

    public function getValue(): ?float {
        return $this->value;
    }

    public function setValue(float $value): self {
        $this->value = $value;

        return $this;
    }

    public function getStatus(): ?int {
        return $this->status;
    }

    public function setStatus(int $status): self {
        $this->status = $status;

        return $this;
    }

}