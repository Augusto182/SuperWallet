<?php
// src/Entity/Client.php

namespace SuperWallet\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="client")
 */
class Client {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    protected $document;

    /**
     * @ORM\Column(type="string")
     */
    protected $mail;

    /**
     * @ORM\Column(type="integer")
     */
    protected $phone;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    // Getters and setters for the above properties
}