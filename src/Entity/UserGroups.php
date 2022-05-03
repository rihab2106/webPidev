<?php

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserGroups
 *
 * @ORM\Table(name="user_groups", indexes={@ORM\Index(name="fk_ID_GROUP", columns={"ID_GROUP"}), @ORM\Index(name="fk_ID_USER", columns={"ID_USER"})})
 * @ORM\Entity
 */
class UserGroups
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_USERS_GPS", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUsersGps;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    private $status;

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
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     * })
     */
    private $idUser;

    public function getIdUsersGps(): ?int
    {
        return $this->idUsersGps;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getIdGroup(): ?Groups
    {
        return $this->idGroup;
    }

    public function setIdGroup(?Groups $idGroup): self
    {
        $this->idGroup = $idGroup;

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
