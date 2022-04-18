<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Teams
 *
 * @ORM\Table(name="teams", indexes={@ORM\Index(name="FK_TEAMS_REFERENCE_COMPETIT", columns={"ID_COMPETION"})})
 * @ORM\Entity(repositoryClass="App\Repository\TeamsRepository")
 */
class Teams
{
    /**
     * @var int
     * @ORM\Column(name="ID_TEAM", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTeam;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TEAM_NAME", type="string", length=50, nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank()
     */
    private $teamName ;

    /**
     * @var \Competitions
     *
     * @ORM\ManyToOne(targetEntity="Competitions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_COMPETION", referencedColumnName="ID_COMPETION")
     * })
     */
    private $idCompetion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="idTeam")
     */
    private $idUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdTeam(): ?int
    {
        return $this->idTeam;
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

    public function getIdCompetion(): ?Competitions
    {
        return $this->idCompetion;
    }

    public function setIdCompetion(?Competitions $idCompetion): self
    {
        $this->idCompetion = $idCompetion;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getIdUser(): Collection
    {
        return $this->idUser;
    }

    public function addIdUser(Users $idUser): self
    {
        if (!$this->idUser->contains($idUser)) {
            $this->idUser[] = $idUser;
            $idUser->addIdTeam($this);
        }

        return $this;
    }

    public function removeIdUser(Users $idUser): self
    {
        if ($this->idUser->removeElement($idUser)) {
            $idUser->removeIdTeam($this);
        }

        return $this;
    }

}
