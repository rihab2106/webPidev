<?php

namespace App\Entity;

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

    /**
     * @var \News
     *
     * @ORM\ManyToOne(targetEntity="News")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_NEWS", referencedColumnName="ID_NEWS")
     * })
     */
    private $idNews;


}
