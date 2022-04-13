<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userteams
 *
 * @ORM\Table(name="userteams", indexes={@ORM\Index(name="FK_USERTEAM_REFERENCE_GAMES", columns={"ID_GAME"}), @ORM\Index(name="FK_USERTEAM_REFERENCE_USERS", columns={"ID_USER"}), @ORM\Index(name="IDX_B1661E8AB1446B03", columns={"ID_TEAM"})})
 * @ORM\Entity
 */
class Userteams
{
    /**
     * @var \Teams
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Teams")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_TEAM", referencedColumnName="ID_TEAM")
     * })
     */
    private $idTeam;

    /**
     * @var \Games
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Games")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_GAME", referencedColumnName="ID_GAME")
     * })
     */
    private $idGame;

    /**
     * @var \Users
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     * })
     */
    private $idUser;


}
