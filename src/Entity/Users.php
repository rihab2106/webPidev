<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="ID_USER",type="integer")
     */
    private $id;
    /**
     * @ORM\Column(name="FULL_NAME",type="string", length=255 , nullable=true)
     */
    private $fullName;


    /**
     * @ORM\Column(name="EMAIL",type="string", length=180, unique=true)
     */
    private $email;
    /**
     * @var string The hashed password
     * @ORM\Column(name="PASSWORD", type="string" )
     */
    private $password;

    /**
     * @ORM\Column(name="ISACTIVE",type="integer", nullable=true)
     */
    private $isactive;

    /**
     * @ORM\Column(name="PRIVILEGE_",type="integer", nullable=true)
     */
    private $privilege;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="boolean", name="isverified")
     */
    private $isVerified = false;







    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFULLNAME(): ?string
    {
        return $this->fullName;
    }

    public function setFULLNAME(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getISACTIVE(): ?int
    {
        return $this->ISACTIVE;
    }

    public function setISACTIVE(int $ISACTIVE): self
    {
        $this->ISACTIVE = $ISACTIVE;

        return $this;
    }

    public function getPRIVILEGE(): ?int
    {
        return $this->PRIVILEGE_;
    }

    public function setPRIVILEGE(?int $PRIVILEGE_): self
    {
        $this->PRIVILEGE_ = $PRIVILEGE_;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}