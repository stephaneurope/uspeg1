<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryAdherentRepository")
 *
 */
class CategoryAdherent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantcot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pack")
     */
    private $pack;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $list;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

   

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMontantcot(): ?int
    {
        return $this->montantcot;
    }

    public function setMontantcot(int $montantcot): self
    {
        $this->montantcot = $montantcot;

        return $this;
    }

    public function getPack(): ?Pack
    {
        return $this->pack;
    }

    public function setPack(?Pack $pack): self
    {
        $this->pack = $pack;

        return $this;
    }

    public function getList(): ?int
    {
        return $this->list;
    }

    public function setList(?int $list): self
    {
        $this->list = $list;

        return $this;
    }
    public function __toString()
    {
        return $this->title;
    }

    
}
