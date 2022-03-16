<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     *
     * @ORM\Column(name="HEADLINE", type="string", length=100, nullable=true)
     */
    private $headline;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CONTENT", type="text", length=65535, nullable=true)
     */
    private $content;

    /**
     * @var string|null
     *
     * @ORM\Column(name="IMG", type="string", length=200, nullable=true)
     */
    private $img;


}
