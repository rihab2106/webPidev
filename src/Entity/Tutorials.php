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
     * @ORM\Column(name="PATH", type="string", length=200, nullable=true)
     */
    private $path;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CONTENT", type="text", length=65535, nullable=true)
     */
    private $content;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     * })
     */
    private $idUser;

    /**
     * @var \Trophies
     *
     * @ORM\ManyToOne(targetEntity="Trophies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_TROPHY", referencedColumnName="ID_TROPHY")
     * })
     */
    private $idTrophy;


}
