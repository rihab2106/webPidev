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
<<<<<<< HEAD
     * @ORM\Column(name="SUM", type="float", precision=8, scale=2, nullable=true)
     */
    private $sum;
=======
     * @ORM\Column(name="SUM", type="float", precision=8, scale=2, nullable=true, options={"default"="NULL"})
     */
    private $sum = NULL;
>>>>>>> o/competitionsTeams

    /**
     * @var float|null
     *
<<<<<<< HEAD
     * @ORM\Column(name="DISCOUNT", type="float", precision=10, scale=0, nullable=true)
     */
    private $discount;
=======
     * @ORM\Column(name="DISCOUNT", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $discount = NULL;
>>>>>>> o/competitionsTeams

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     * })
     */
    private $idUser;

<<<<<<< HEAD
=======
    public function getIdCart(): ?int
    {
        return $this->idCart;
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

    public function getIdUser(): ?Users
    {
        return $this->idUser;
    }

    public function setIdUser(?Users $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

>>>>>>> o/competitionsTeams

}
