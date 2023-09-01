<?php
// src/Entity/Order.php

namespace SuperWallet\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order")
 */
class Order {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Wallet")
     * @ORM\JoinColumn(name="wallet_id", referencedColumnName="id")
     */
    protected $wallet;

    /**
     * @ORM\Column(type="string")
     */
    protected $sessionId;

    /**
     * @ORM\Column(type="string")
     */
    protected $token;

    /**
     * @ORM\Column(type="float")
     */
    protected $value;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $status;

    // Getters and setters for the above properties
}