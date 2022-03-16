<?php

namespace App\Entity;

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
     * @var string|null
     *
     * @ORM\Column(name="TEAM_NAME", type="string", length=50, nullable=true)
     */
    private $teamName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CREATOR", type="string", length=50, nullable=true)
     */
    private $creator;

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

}
