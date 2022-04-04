<?php

namespace App\Entity;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="fk_Category", columns={"ID_CATEGORY"})})
 * @ORM\Entity
 * @Vich\Uploadable
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
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=1000, nullable=false)
     */
    private $description;

    /**
     * @var float|null
     *
     * @ORM\Column(name="PRICE", type="float", precision=8, scale=2, nullable=true)
     */
    private $price;

    /**
     * @var float|null
     *
     * @ORM\Column(name="DISCOUNT", type="float", precision=10, scale=0, nullable=true)
     */
    private $discount;

    /**
     * @var int
     *
     * @ORM\Column(name="Quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="string", length=1000, nullable=false)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CATEGORY", referencedColumnName="ID_CATEGORY")
     * })
     */
    private $idCategory;

    public function getIdProduct(): ?int
    {
        return $this->idProduct;
    }

    public function getProdName(): ?string
    {
        return $this->prodName;
    }

    public function setProdName(?string $prodName): self
    {
        $this->prodName = $prodName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
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

    public function getIdCategory(): ?Category
    {
        return $this->idCategory;
    }

    public function setIdCategory(?Category $idCategory): self
    {
        $this->idCategory = $idCategory;

        return $this;
    }


}
