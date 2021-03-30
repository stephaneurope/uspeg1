<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmountRepository")
 */
class Amount
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paymentMethodAmount1;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paymentMethodAmount2;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount3;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paymentMethodAmount3;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount4;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paymentMethodAmount4;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amountTotal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adherent", inversedBy="amounts")
     */
    private $adherent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numcheque;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numcheque2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numcheque3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numcheque4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name4;

  /*  public function __construct()
    {
        $this->adherent = new ArrayCollection();
    }*/

    public function getId(): ?int
    {
        return $this->id;
    }
    
    

    public function getAmount1(): ?float
    {
        return $this->amount1;
    }

    public function setAmount1(?float $amount1): self
    {
        $this->amount1 = $amount1;

        return $this;
    }

    public function getPaymentMethodAmount1(): ?string
    {
        return $this->paymentMethodAmount1;
    }

    public function setPaymentMethodAmount1(?string $paymentMethodAmount1): self
    {
        $this->paymentMethodAmount1 = $paymentMethodAmount1;

        return $this;
    }

    public function getAmount2(): ?float
    {
        return $this->amount2;
    }

    public function setAmount2(?float $amount2): self
    {
        $this->amount2 = $amount2;

        return $this;
    }

    public function getPaymentMethodAmount2(): ?string
    {
        return $this->paymentMethodAmount2;
    }

    public function setPaymentMethodAmount2(?string $paymentMethodAmount2): self
    {
        $this->paymentMethodAmount2 = $paymentMethodAmount2;

        return $this;
    }

    public function getAmount3(): ?float
    {
        return $this->amount3;
    }

    public function setAmount3(?float $amount3): self
    {
        $this->amount3 = $amount3;

        return $this;
    }

    public function getPaymentMethodAmount3(): ?string
    {
        return $this->paymentMethodAmount3;
    }

    public function setPaymentMethodAmount3(?string $paymentMethodAmount3): self
    {
        $this->paymentMethodAmount3 = $paymentMethodAmount3;

        return $this;
    }

    public function getAmount4(): ?float
    {
        return $this->amount4;
    }

    public function setAmount4(?float $amount4): self
    {
        $this->amount4 = $amount4;

        return $this;
    }

    public function getPaymentMethodAmount4(): ?string
    {
        return $this->paymentMethodAmount4;
    }

    public function setPaymentMethodAmount4(?string $paymentMethodAmount4): self
    {
        $this->paymentMethodAmount4 = $paymentMethodAmount4;

        return $this;
    }

    public function getAmountTotal(): ?float
    {
        return $this->amountTotal;
    }

    public function setAmountTotal(?float $amountTotal): self
    {
        $this->amountTotal = $amountTotal;

        return $this;
    }

    public function getAdherent(): ?Adherent
    {
        return $this->adherent;
    }

    public function setAdherent(?Adherent $adherent): self
    {
        $this->adherent = $adherent;

        return $this;
    }

    public function getNumcheque(): ?string
    {
        return $this->numcheque;
    }

    public function setNumcheque(?string $numcheque): self
    {
        $this->numcheque = $numcheque;

        return $this;
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

    public function getNumcheque2(): ?string
    {
        return $this->numcheque2;
    }

    public function setNumcheque2(?string $numcheque2): self
    {
        $this->numcheque2 = $numcheque2;

        return $this;
    }

    public function getName2(): ?string
    {
        return $this->name2;
    }

    public function setName2(?string $name2): self
    {
        $this->name2 = $name2;

        return $this;
    }

    public function getNumcheque3(): ?string
    {
        return $this->numcheque3;
    }

    public function setNumcheque3(?string $numcheque3): self
    {
        $this->numcheque3 = $numcheque3;

        return $this;
    }

    public function getName3(): ?string
    {
        return $this->name3;
    }

    public function setName3(?string $name3): self
    {
        $this->name3 = $name3;

        return $this;
    }

    public function getNumcheque4(): ?string
    {
        return $this->numcheque4;
    }

    public function setNumcheque4(?string $numcheque4): self
    {
        $this->numcheque4 = $numcheque4;

        return $this;
    }

    public function getName4(): ?string
    {
        return $this->name4;
    }

    public function setName4(?string $name4): self
    {
        $this->name4 = $name4;

        return $this;
    }
}
