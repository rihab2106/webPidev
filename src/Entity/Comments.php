<?php

namespace App\Entity;

use App\Entity\News;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;





/**
 * Comments
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="FK_COMMENTS_REFERENCE_NEWS", columns={"ID_NEWS"})})
 * @ORM\Entity(repositoryClass="App\Repository\CommentsRepository")
 * 

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
     * @var ?News
     *
     * 
     * @ORM\ManyToOne(targetEntity="News")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="ID_NEWS", referencedColumnName="ID_NEWS")
     * })
     */
    private $idNews;

    /**
     * @var string
     * @Assert\NotBlank(message="Your comment cannot be empty")
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Comments must be at least {{ limit }} characters long",
     *      maxMessage = "Comments cannot be longer than {{ limit }} characters")
     * @ORM\Column(name="COMMENT", type="string", length=512, nullable=false)
     */
    private $comment;

    /**
     * @var int|null
     * 
     * @ORM\Column(name="LIKES", type="integer", options={"default" : 0},nullable=true)
     */
    private $likes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="DISLIKES", type="integer",options={"default" : 0}, nullable=true)
     */
    private $dislikes;

    public function getIdComment(): ?int
    {
        return $this->idComment;
    }

    public function getIdNews(): ?News
    {
        return $this->idNews;
    }

    public function setIdNews(?News $idNews):self
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