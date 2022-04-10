<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity
 */
class Groups
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_GROUP", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGroup;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NAME", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $name = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="IMG", type="string", length=200, nullable=true, options={"default"="NULL"})
     */
    private $img = 'NULL';

    public function getIdGroup(): ?int
    {
        return $this->idGroup;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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


}
