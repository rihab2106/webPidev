<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order
 *
 * @ORM\Table(name="order")
 * @ORM\Entity
 */
class Order
{
    /**
     * @var int
     *
     * @ORM\Column(name="OrderID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $orderid;

    /**
     * @var string
     *
     * @ORM\Column(name="CardNumber", type="string", length=220, nullable=false)
     */
    private $cardnumber;

    /**
     * @var string
     *
     * @ORM\Column(name="CardPassword", type="string", length=140, nullable=false)
     */
    private $cardpassword;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="Month", type="integer", nullable=false)
     */
    private $month;

    /**
     * @var int
     *
     * @ORM\Column(name="Year", type="integer", nullable=false)
     */
    private $year;

    public function getOrderid(): ?int
    {
        return $this->orderid;
    }

    public function getCardnumber(): ?string
    {
        return $this->cardnumber;
    }

    public function setCardnumber(string $cardnumber): self
    {
        $this->cardnumber = $cardnumber;

        return $this;
    }

    public function getCardpassword(): ?string
    {
        return $this->cardpassword;
    }

    public function setCardpassword(string $cardpassword): self
    {
        $this->cardpassword = $cardpassword;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(int $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }


}
