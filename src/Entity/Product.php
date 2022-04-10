<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_PRODUCT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduct;

    /**
     * @var string
     *
     * @ORM\Column(name="PROD_NAME", type="string", length=100, nullable=false)
     */
    private $prodName;

    /**
     * @var float
     *
     * @ORM\Column(name="PRICE", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="Category", type="string", length=200, nullable=false)
     */
    private $category;

    /**
     * @var int
     *
     * @ORM\Column(name="DISCOUNT", type="integer", nullable=false)
     */
    private $discount;

    public function getIdProduct(): ?int
    {
        return $this->idProduct;
    }

    public function getProdName(): ?string
    {
        return $this->prodName;
    }

    public function setProdName(string $prodName): self
    {
        $this->prodName = $prodName;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }


}
