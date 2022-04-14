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
     * @var int|null
     *
     * @ORM\Column(name="ID_USER", type="integer", nullable=true)
     */
    private $idUser;

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

    public function getIdCart(): ?int
    {
        return $this->idCart;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(?int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getSum(): ?float
    {
        return $this->sum;
    }

    public function setSum(?float $sum): self
    {
        $this->sum = $sum;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }


}
