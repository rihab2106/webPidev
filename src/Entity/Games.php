<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Games
 *
 * @ORM\Table(name="games", indexes={@ORM\Index(name="FK_GAMES_REFERENCE_CATEGORY", columns={"ID_CATEGORY"})})
 * @ORM\Entity
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
     * @var int|null
     *
     * @ORM\Column(name="ID_CATEGORY", type="integer", nullable=true)
     */
    private $idCategory;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NAME", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESCRIPTION", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="RATE", type="decimal", precision=8, scale=4, nullable=true)
     */
    private $rate;

    public function getIdGame(): ?int
    {
        return $this->idGame;
    }

    public function getIdCategory(): ?int
    {
        return $this->idCategory;
    }

    public function setIdCategory(?int $idCategory): self
    {
        $this->idCategory = $idCategory;

        return $this;
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


}
