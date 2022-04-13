<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity
 */
class News
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_NEWS", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNews;

    /**
     * @var string|null
     *@Assert\NotBlank
     * @ORM\Column(name="HEADLINE", type="string", length=100, nullable=true)
     */
    private $headline;

    /**
     * @var string|null
     *@Assert\NotBlank
     * @ORM\Column(name="CONTENT", type="text", length=65535, nullable=true)
     */
    private $content;

    /**
     * @var string|null
     *@Assert\NotBlank
     * @ORM\Column(name="IMG", type="string", length=200, nullable=true)
     */
    private $img;

    public function getIdNews(): ?int
    {
        return $this->idNews;
    }

    public function getHeadline(): ?string
    {
        return $this->headline;
    }

    public function setHeadline(?string $headline): self
    {
        $this->headline = $headline;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

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
    public function __toString() {
        return $this->idNews;
    }


}
