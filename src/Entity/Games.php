<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Games
 *
 * @ORM\Table(name="games", indexes={@ORM\Index(name="FK_GAMES_REFERENCE_CATEGORY", columns={"ID_CATEGORY"})})
 * @ORM\Entity(repositoryClass="App\Repository\GamesRepository")
 */
class Games
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_GAME", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGame;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NAME", type="string", length=100, nullable=true)
     * @Assert\NotBlank(message="You must write a name")
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESCRIPTION", type="text", length=65535, nullable=true)
     * @Assert\NotBlank(message="You must write a description")
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="RATE", type="decimal", precision=8, scale=4, nullable=true)
     * @Assert\GreaterThanOrEqual(value="0")
     * @Assert\LessThanOrEqual(value="100")
     * @Assert\NotBlank(message="You must write a rate")
     *
     */
    private $rate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="img", type="string", length=1000, nullable=true)
     * @Assert\Image(mimeTypes={"image/jpeg", "image/png"}, mimeTypesMessage="Please upload a valid image")
     */
    private $img;

    /**
     * @var ?Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CATEGORY", referencedColumnName="ID_CATEGORY")
     * })
     */
    private $Category;

    public function getIdGame(): ?int
    {
        return $this->idGame;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(?string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }


}
