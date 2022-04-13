<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Length(min=5, max=10)
     * @ORM\Column(name="COMMENT", type="string", length=512, nullable=true)
     */
    private $comment;

    /**
     * @var int|null
     * @Assert\Range(
     *      min = 1,
     *      notInRangeMessage = " Likes Cannot be less than 0",
     * )
     * @ORM\Column(name="LIKES", type="integer", nullable=true)
     */
    private $likes;

    /**
     * @var int|null
     * * @Assert\Range(
     *      min = 1,
     *      notInRangeMessage = " Likes Cannot be less than 0",
     * )
     * @ORM\Column(name="DISLIKES", type="integer", nullable=true)
     */
    private $dislikes;

    /**
     * @var ?News
     *
     * @ORM\ManyToOne(targetEntity="News")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_NEWS", referencedColumnName="ID_NEWS")
     * })
     */
    private $idNews;

    public function getIdComment(): ?int
    {
        return $this->idComment;
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

    public function getIdNews(): ?News
    {
        return $this->idNews;
    }

    public function setIdNews(?News $idNews): self
    {
        $this->idNews = $idNews;

        return $this;
    }


}
