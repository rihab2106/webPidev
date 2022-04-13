<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competitions
 *
 * @ORM\Table(name="competitions", indexes={@ORM\Index(name="FK_COMPETIT_REFERENCE_GAMES", columns={"ID_GAME"})})
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="BEGIN", type="date", nullable=true)
     */
    private $begin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="GAME_NAME", type="string", length=30, nullable=true)
     */
    private $gameName;

    /**
     * @var \Games
     *
     * @ORM\ManyToOne(targetEntity="Games")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_GAME", referencedColumnName="ID_GAME")
     * })
     */
    private $idGame;


}
