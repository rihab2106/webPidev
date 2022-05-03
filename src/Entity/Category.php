<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_CATEGORY", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idCategory;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CATEGORY", type="string", length=30, nullable=true)
     * @Assert\NotBlank(message="You must enter a category")
     *
     * @Assert\Regex(pattern="/^[a-zA-Z]+$/")
     */
    private $category;

    public function __toString()
    {
        return $this->category;
    }

    public function getIdCategory(): ?int
    {
        return $this->idCategory;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }


}
