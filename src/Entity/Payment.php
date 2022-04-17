<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
/**
 * Payment
 *
 * @ORM\Table(name="payment")
 * @ORM\Entity
 */
class Payment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_payment", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPayment;

    /**
     * @var string
     *@Assert\NotBlank(message=" Title shouldn't be empty")
     * @ORM\Column(name="cardnumber", type="string")
     * @Assert\Length(
     *     min = 16,
     *     max = 16)
     *
     */

    private $cardnumber;

    /**
     * @var int
     *@Assert\NotBlank(message=" Title shouldn't be empty")
     * @ORM\Column(name="cvv", type="integer")
     * @Assert\Length(
     *     min=3,
     *     max = 3)
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid CVV.")
     */
    private $cvv;

    /**
     * @var string
     *@Assert\NotBlank(message=" Title shouldn't be empty")
     * @ORM\Column(name="expiration", type="string", length=800)
     * @Assert\Length(
     *     min = 4,
     *     max = 4)
     * @Assert\Regex("/^(0[1-9]|1[0-2]).\d/",
     * message="Enter a date in format :  monthyear ex: 1219")
     */
    private $expiration;

    /**
     * @var string
     *@Assert\NotBlank(message=" Title shouldn't be empty")
     * @ORM\Column(name="Nameincard", type="string", length=255)
     */
    private $nameincard;

    public function getIdPayment(): ?int
    {
        return $this->idPayment;
    }

    public function getCardnumber(): ?int
    {
        return $this->cardnumber;
    }

    public function setCardnumber(int $cardnumber): self
    {
        $this->cardnumber = $cardnumber;

        return $this;
    }

    public function getCvv(): ?int
    {
        return $this->cvv;
    }

    public function setCvv(int $cvv): self
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function getExpiration(): ?string
    {
        return $this->expiration;
    }

    public function setExpiration(string $expiration): self
    {
        $this->expiration = $expiration;

        return $this;
    }

    public function getNameincard(): ?string
    {
        return $this->nameincard;
    }

    public function setNameincard(string $nameincard): self
    {
        $this->nameincard = $nameincard;

        return $this;
    }


}
