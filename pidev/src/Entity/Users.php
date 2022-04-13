<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users", indexes={@ORM\Index(name="FK_USERS_REFERENCE_GROUPS", columns={"ID_GROUP"})})
 * @ORM\Entity
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_USER", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="FULL_NAME", type="string", length=100, nullable=true)
     */
    private $fullName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="IMG", type="string", length=100, nullable=true)
     */
    private $img;

    /**
     * @var string|null
     *
     * @ORM\Column(name="EMAIL", type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PASSWORD", type="string", length=200, nullable=true)
     */
    private $password;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="ISACTIVE", type="boolean", nullable=true)
     */
    private $isactive;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="PRIVILEGE_", type="boolean", nullable=true)
     */
    private $privilege;

    /**
     * @var \Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_GROUP", referencedColumnName="ID_GROUP")
     * })
     */
    private $idGroup;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Teams", inversedBy="idUser")
     * @ORM\JoinTable(name="members",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_TEAM", referencedColumnName="ID_TEAM")
     *   }
     * )
     */
    private $idTeam;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idTeam = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
