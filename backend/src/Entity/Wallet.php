<?php
// src/Entity/Wallet.php

namespace SuperWallet\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "wallet")]
class Wallet {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected $id;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    #[ORM\JoinColumn(name: "client_id", referencedColumnName: "id")]
    protected $client_id;

    #[ORM\Column(type: "float")]
    protected $value;

    // Getters and setters for the above properties
    public function getId(): ?int {
        return $this->id;
    }

    public function getClient(): ?Client {
        return $this->client_id;
    }

    public function setClient(Client $clientId): self {
        $this->client_id = $clientId;
        return $this;
    }

    public function getValue(): ?float {
        return $this->value;
    }

    public function setValue(float $value): self {
        $this->value = $value;

        return $this;
    }

}