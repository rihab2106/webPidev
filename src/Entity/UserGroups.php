<?php

namespace App\Entity;

use App\Repository\UserGroupsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserGroupsRepository::class)
 */
class UserGroups
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="ID_USERS_GPS",type="integer")
     */
    private $idUsersGps;
    /**
     * @var \Users
     *  @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumn(name="ID_USER", referencedColumnName="ID_USER")
     */
    private $idUser;

    /**
     * @var \Groups
     *@ORM\ManyToOne(targetEntity="Groups")
     *@ORM\JoinColumn(name="ID_GROUP", referencedColumnName="ID_GROUP")
     */
    private $idGroup;
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $status;



    public function getId(): ?int
    {
        return $this->idUsersGps;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @return \Users
     */
    public function getIdUser(): \Users
    {
        return $this->idUser;
    }

    /**
     * @param \Users $idUser
     */
    public function setIdUser(\Users $idUser): void
    {
        $this->idUser = $idUser;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return \Groups
     */
    public function getIdGroup(): \Groups
    {
        return $this->idGroup;
    }

    /**
     * @param \Groups $idGroup
     */
    public function setIdGroup(\Groups $idGroup): void
    {
        $this->idGroup = $idGroup;
    }

    public function getIdUsersGps(): ?int
    {
        return $this->idUsersGps;
    }
}
