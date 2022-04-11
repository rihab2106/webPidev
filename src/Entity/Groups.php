<?php

namespace App\Entity;

use App\Repository\GroupsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupsRepository::class)
 */
class Groups
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="ID_GROUP",type="integer")
     */
    private $idGroup;

    /**
     * @ORM\Column(name="NAME",type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=UserGroups::class, mappedBy="Groups", orphanRemoval=true)
     */
    private $userGroups;

    public function __construct()
    {
        $this->userGroups = new ArrayCollection();
    }

    public function getIdGroup(): ?int
    {
        return $this->idGroup;
    }

    public function getNAME(): ?string
    {
        return $this->name;
    }

    public function setNAME(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, UserGroups>
     */
    public function getUserGroups(): Collection
    {
        return $this->userGroups;
    }

    public function addUserGroup(UserGroups $userGroup): self
    {
        if (!$this->userGroups->contains($userGroup)) {
            $this->userGroups[] = $userGroup;
            $userGroup->setGroups($this);
        }

        return $this;
    }

    public function removeUserGroup(UserGroups $userGroup): self
    {
        if ($this->userGroups->removeElement($userGroup)) {
            // set the owning side to null (unless already changed)
            if ($userGroup->getGroups() === $this) {
                $userGroup->setGroups(null);
            }
        }

        return $this;
    }
}
