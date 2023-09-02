<?php
// src/Entity/Client.php

namespace SuperWallet\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "client")]
class Client {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected $id;

    #[ORM\Column(type: "integer", unique: true)]
    protected $document;

    #[ORM\Column(type: "string")]
    protected $mail;

    #[ORM\Column(type: "integer")]
    protected $phone;

    #[ORM\Column(type: "string")]
    protected $name;

    // Getters and setters for the above properties

    public function getId(): ?int {
        return $this->id;
    }

    public function getDocument(): ?int {
        return $this->document;
    }

    public function setDocument(int $document): self {
        $this->document = $document;

        return $this;
    }

    public function getMail(): ?string {
        return $this->mail;
    }

    public function setMail(string $mail): self {
        $this->mail = $mail;

        return $this;
    }

    public function getPhone(): ?int {
        return $this->phone;
    }

    public function setPhone(int $phone): self {
        $this->phone = $phone;

        return $this;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }
}