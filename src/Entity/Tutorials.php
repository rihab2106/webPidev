<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tutorials
 *
 * @ORM\Table(name="tutorials", indexes={@ORM\Index(name="FK_TUTORIAL_REFERENCE_TROPHIES", columns={"ID_TROPHY"}), @ORM\Index(name="FK_TUTORIAL_REFERENCE_USERS", columns={"ID_USER"})})
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
     * @var string|null
     *
     * @ORM\Column(name="PATH", type="string", length=200, nullable=true, options={"default"="NULL"})
     */
    private $path = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="CONTENT", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $content = 'NULL';

    /**
     * @var \Trophies
     *
     * @ORM\ManyToOne(targetEntity="Trophies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_TROPHY", referencedColumnName="ID_TROPHY")
     * })
     */
    private $idTrophy;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     * })
     */
    private $idUser;

    public function getIdTutorial(): ?int
    {
        return $this->idTutorial;
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

    public function getIdTrophy(): ?Trophies
    {
        return $this->idTrophy;
    }

    public function setIdTrophy(?Trophies $idTrophy): self
    {
        $this->idTrophy = $idTrophy;

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


}
