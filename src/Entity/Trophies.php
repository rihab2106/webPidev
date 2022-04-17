<?php

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trophies
 *
 * @ORM\Table(name="trophies", indexes={@ORM\Index(name="FK_TROPHIES_REFERENCE_GAMES", columns={"ID_GAME"})})
 * @ORM\Entity
 */
class Trophies
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_TROPHY", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTrophy;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ID_GAME", type="integer", nullable=true)
     */
    private $idGame;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TITLE", type="string", length=30, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PLATFORM", type="string", length=20, nullable=true)
     */
    private $platform;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DIFFICULITY", type="string", length=20, nullable=true)
     */
    private $difficulity;

    public function getIdTrophy(): ?int
    {
        return $this->idTrophy;
    }

    public function getIdGame(): ?int
    {
        return $this->idGame;
    }

    public function setIdGame(?int $idGame): self
    {
        $this->idGame = $idGame;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(?string $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function getDifficulity(): ?string
    {
        return $this->difficulity;
    }

    public function setDifficulity(?string $difficulity): self
    {
        $this->difficulity = $difficulity;

        return $this;
    }


}
