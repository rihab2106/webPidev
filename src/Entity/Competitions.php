<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Competitions
 *
 * @ORM\Table(name="competitions")
 * @ORM\Entity
 */
class Competitions
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_COMPETION", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCompetion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="GAME_NAME", type="string", length=30, nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank()
     */
    private $gameName;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATEOFCOMP", type="date", nullable=true, options={"default"="NULL"})
     */
    private $dateofcomp ;

    public function getIdCompetion(): ?int
    {
        return $this->idCompetion;
    }

    public function getGameName(): ?string
    {
        return $this->gameName;
    }

    public function setGameName(?string $gameName): self
    {
        $this->gameName = $gameName;

        return $this;
    }

    public function getDateofcomp(): ?\DateTimeInterface
    {
        return $this->dateofcomp;
    }

    public function setDateofcomp(?\DateTimeInterface $dateofcomp): self
    {
        $this->dateofcomp = $dateofcomp;

        return $this;
    }


}
