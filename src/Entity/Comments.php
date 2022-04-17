<?php

namespace App\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="FK_COMMENTS_REFERENCE_NEWS", columns={"ID_NEWS"})})
 * @ORM\Entity
 */
class Comments
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_COMMENT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idComment;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ID_NEWS", type="integer", nullable=true)
     */
    private $idNews;

    /**
     * @var string|null
     *
     * @ORM\Column(name="COMMENT", type="string", length=512, nullable=true)
     */
    private $comment;

    /**
     * @var int|null
     *
     * @ORM\Column(name="LIKES", type="integer", nullable=true)
     */
    private $likes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="DISLIKES", type="integer", nullable=true)
     */
    private $dislikes;

    public function getIdComment(): ?int
    {
        return $this->idComment;
    }

    public function getIdNews(): ?int
    {
        return $this->idNews;
    }

    public function setIdNews(?int $idNews): self
    {
        $this->idNews = $idNews;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getDislikes(): ?int
    {
        return $this->dislikes;
    }

    public function setDislikes(?int $dislikes): self
    {
        $this->dislikes = $dislikes;

        return $this;
    }


}
