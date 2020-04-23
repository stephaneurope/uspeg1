<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryproduitRepository")
 */
class Categoryproduit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Categoryproduit")
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Produit", mappedBy="categoryproduit")
     */
    private $produit;
    
    public function __construct() {
        $this->produits = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function addTitle(produit $title): self
    {
        if (!$this->title->contains($title)) {
            $this->title[] = $title;
            $title->setCategoryproduit($this);
        }

        return $this;
    }

    public function removeTitle(Produit $title): self
    {
        if ($this->title->contains($title)) {
            $this->title->removeElement($title);
            // set the owning side to null (unless already changed)
            if ($title->getCategoryproduit() === $this) {
                $title->setCategoryproduit(null);
            }
        }

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

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
}
