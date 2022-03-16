<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="FK_PRODUCT_REFERENCE_CART", columns={"ID_cart"}), @ORM\Index(name="FK_PRODUCT_REFERENCE_CATEGORY", columns={"ID_CATEGORY"})})
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
     * @var string|null
     *
     * @ORM\Column(name="PROD_NAME", type="string", length=100, nullable=true)
     */
    private $prodName;

    /**
     * @var float|null
     *
     * @ORM\Column(name="PRICE", type="float", precision=8, scale=2, nullable=true)
     */
    private $price;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="DISCOUNT", type="boolean", nullable=true)
     */
    private $discount;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CATEGORY", referencedColumnName="ID_CATEGORY")
     * })
     */
    private $idCategory;

    /**
     * @var \Cart
     *
     * @ORM\ManyToOne(targetEntity="Cart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_cart", referencedColumnName="ID_cart")
     * })
     */
    private $idCart;


}
