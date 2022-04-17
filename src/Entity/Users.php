<?php

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
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


}
