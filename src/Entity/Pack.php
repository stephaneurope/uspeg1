<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PackRepository")
 */
class Pack
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option7;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option8;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option9;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $option10;

    /**
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\CategoryAdherent", mappedBy="pack",orphanRemoval=true)
     * @JoinColumn(name="pack_id", referencedColumnName="pack_id",nullable=true)
     */
    private $categoryAdherents;

    public function __construct()
    {
        $this->categoryAdherents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOption1(): ?string
    {
        return $this->option1;
    }

    public function setOption1(?string $option1): self
    {
        $this->option1 = $option1;

        return $this;
    }

    public function getOption2(): ?string
    {
        return $this->option2;
    }

    public function setOption2(?string $option2): self
    {
        $this->option2 = $option2;

        return $this;
    }

    public function getOption3(): ?string
    {
        return $this->option3;
    }

    public function setOption3(?string $option3): self
    {
        $this->option3 = $option3;

        return $this;
    }

    public function getOption4(): ?string
    {
        return $this->option4;
    }

    public function setOption4(?string $option4): self
    {
        $this->option4 = $option4;

        return $this;
    }

    public function getOption5(): ?string
    {
        return $this->option5;
    }

    public function setOption5(?string $option5): self
    {
        $this->option5 = $option5;

        return $this;
    }

    public function getOption6(): ?string
    {
        return $this->option6;
    }

    public function setOption6(?string $option6): self
    {
        $this->option6 = $option6;

        return $this;
    }

    public function getOption7(): ?string
    {
        return $this->option7;
    }

    public function setOption7(?string $option7): self
    {
        $this->option7 = $option7;

        return $this;
    }

    public function getOption8(): ?string
    {
        return $this->option8;
    }

    public function setOption8(?string $option8): self
    {
        $this->option8 = $option8;

        return $this;
    }

    public function getOption9(): ?string
    {
        return $this->option9;
    }

    public function setOption9(?string $option9): self
    {
        $this->option9 = $option9;

        return $this;
    }

    public function getOption10(): ?string
    {
        return $this->option10;
    }

    public function setOption10(?string $option10): self
    {
        $this->option10 = $option10;

        return $this;
    }

    /**
     * @return Collection|CategoryAdherent[]
     */
    public function getCategoryAdherents(): Collection
    {
        return $this->categoryAdherents;
    }

    public function addCategoryAdherent(CategoryAdherent $categoryAdherent): self
    {
        if (!$this->categoryAdherents->contains($categoryAdherent)) {
            $this->categoryAdherents[] = $categoryAdherent;
            $categoryAdherent->setPack($this);
        }

        return $this;
    }

    public function removeCategoryAdherent(CategoryAdherent $categoryAdherent): self
    {
        if ($this->categoryAdherents->contains($categoryAdherent)) {
            $this->categoryAdherents->removeElement($categoryAdherent);
            // set the owning side to null (unless already changed)
            if ($categoryAdherent->getPack() === $this) {
                $categoryAdherent->setPack(null);
            }
        }

        return $this;
    }
}
