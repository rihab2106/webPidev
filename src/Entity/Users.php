<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(name="FULL_NAME", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $fullName = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="IMG", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $img = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="EMAIL", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $email = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="PASSWORD", type="string", length=200, nullable=true, options={"default"="NULL"})
     */
    private $password = 'NULL';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="ISACTIVE", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $isactive = 'NULL';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="PRIVILEGE_", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $privilege = 'NULL';

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

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIsactive(): ?bool
    {
        return $this->isactive;
    }

    public function setIsactive(?bool $isactive): self
    {
        $this->isactive = $isactive;

        return $this;
    }

    public function getPrivilege(): ?bool
    {
        return $this->privilege;
    }

    public function setPrivilege(?bool $privilege): self
    {
        $this->privilege = $privilege;

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

    /**
     * @return Collection<int, Teams>
     */
    public function getIdTeam(): Collection
    {
        return $this->idTeam;
    }

    public function addIdTeam(Teams $idTeam): self
    {
        if (!$this->idTeam->contains($idTeam)) {
            $this->idTeam[] = $idTeam;
        }

        return $this;
    }

    public function removeIdTeam(Teams $idTeam): self
    {
        $this->idTeam->removeElement($idTeam);

        return $this;
    }

}
