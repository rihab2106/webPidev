<?php

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userteams
 *
 * @ORM\Table(name="userteams", indexes={@ORM\Index(name="FK_USERTEAM_REFERENCE_GAMES", columns={"ID_GAME"}), @ORM\Index(name="FK_USERTEAM_REFERENCE_USERS", columns={"ID_USER"})})
 * @ORM\Entity
 */
class Userteams
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_TEAM", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idTeam;

    /**
     * @var int
     *
     * @ORM\Column(name="ID_USER", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="ID_GAME", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idGame;

    public function getIdTeam(): ?int
    {
        return $this->idTeam;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getIdGame(): ?int
    {
        return $this->idGame;
    }


}
