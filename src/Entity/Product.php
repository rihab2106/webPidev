<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PROD_NAME;

    /**
     * @ORM\Column(type="float")
     */
    private $PRICE;

    /**
     * @ORM\Column(type="float")
     */
    private $DISCOUNT;

    /**
     * @ORM\Column(type="integer")
     */
    private $Quantity;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPRODNAME(): ?string
    {
        return $this->PROD_NAME;
    }

    public function setPRODNAME(string $PROD_NAME): self
    {
        $this->PROD_NAME = $PROD_NAME;

        return $this;
    }

    public function getPRICE(): ?float
    {
        return $this->PRICE;
    }

    public function setPRICE(float $PRICE): self
    {
        $this->PRICE = $PRICE;

        return $this;
    }

    public function getDISCOUNT(): ?float
    {
        return $this->DISCOUNT;
    }

    public function setDISCOUNT(float $DISCOUNT): self
    {
        $this->DISCOUNT = $DISCOUNT;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
