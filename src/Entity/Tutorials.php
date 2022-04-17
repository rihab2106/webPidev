<?php

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tutorials
 *
 * @ORM\Table(name="tutorials", indexes={@ORM\Index(name="FK_TUTORIAL_REFERENCE_USERS", columns={"ID_USER"}), @ORM\Index(name="FK_TUTORIAL_REFERENCE_TROPHIES", columns={"ID_TROPHY"})})
 * @ORM\Entity
 */
class Tutorials
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_TUTORIAL", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTutorial;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ID_USER", type="integer", nullable=true)
     */
    private $idUser;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ID_TROPHY", type="integer", nullable=true)
     */
    private $idTrophy;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PATH", type="string", length=200, nullable=true)
     */
    private $path;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CONTENT", type="text", length=65535, nullable=true)
     */
    private $content;

    public function getIdTutorial(): ?int
    {
        return $this->idTutorial;
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

    public function getIdTrophy(): ?int
    {
        return $this->idTrophy;
    }

    public function setIdTrophy(?int $idTrophy): self
    {
        $this->idTrophy = $idTrophy;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }


}
