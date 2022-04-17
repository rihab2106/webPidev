<?php

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teams
 *
 * @ORM\Table(name="teams", indexes={@ORM\Index(name="FK_TEAMS_REFERENCE_COMPETIT", columns={"ID_COMPETION"})})
 * @ORM\Entity
 */
class Teams
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_TEAM", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTeam;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ID_COMPETION", type="integer", nullable=true)
     */
    private $idCompetion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TEAM_NAME", type="string", length=50, nullable=true)
     */
    private $teamName;

    public function getIdTeam(): ?int
    {
        return $this->idTeam;
    }

    public function getIdCompetion(): ?int
    {
        return $this->idCompetion;
    }

    public function setIdCompetion(?int $idCompetion): self
    {
        $this->idCompetion = $idCompetion;

        return $this;
    }

    public function getTeamName(): ?string
    {
        return $this->teamName;
    }

    public function setTeamName(?string $teamName): self
    {
        $this->teamName = $teamName;

        return $this;
    }


}
