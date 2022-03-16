<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="cart", indexes={@ORM\Index(name="FK_CART_REFERENCE_USERS", columns={"ID_USER"})})
 * @ORM\Entity
 */
class Cart
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_cart", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCart;

    /**
     * @var float|null
     *
     * @ORM\Column(name="SUM", type="float", precision=8, scale=2, nullable=true)
     */
    private $sum;

    /**
     * @var float|null
     *
     * @ORM\Column(name="DISCOUNT", type="float", precision=10, scale=0, nullable=true)
     */
    private $discount;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     * })
     */
    private $idUser;


}
