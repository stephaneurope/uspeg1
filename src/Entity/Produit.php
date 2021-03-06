<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
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
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $qteinit;

    /**
     * @ORM\Column(type="integer")
     */
    private $qtemin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="produit",cascade={"remove"})
     */
    private $commandes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoryproduit", inversedBy="title")
     * @JoinColumn(name="categoryproduit_id", referencedColumnName="id")
     */
    private $categoryproduit;

    /**
     * @ORM\OneToOne(targetEntity="ImageProduit", cascade={"persist", "remove"})
     */
    private $imageProduit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $taille;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    

    public function getQteinit(): ?int
    {
        return $this->qteinit;
    }

    public function setQteinit(int $qteinit): self
    {
        $this->qteinit = $qteinit;

        return $this;
    }

    public function getQtemin(): ?int
    {
        return $this->qtemin;
    }

    public function setQtemin(int $qtemin): self
    {
        $this->qtemin = $qtemin;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getProduit() === $this) {
                $commande->setProduit(null);
            }
        }

        return $this;
    }

    public function getCategoryproduit(): ?Categoryproduit
    {
        return $this->categoryproduit;
    }

    public function setCategoryproduit(?Categoryproduit $categoryproduit): self
    {
        $this->categoryproduit = $categoryproduit;

        return $this;
    }

    /**
     * Get the value of imageProduit
     */ 
    public function getImageProduit()
    {
        return $this->imageProduit;
    }

    /**
     * Set the value of imageProduit
     *
     * @return  self
     */ 
    public function setImageProduit($imageProduit)
    {
        $this->imageProduit = $imageProduit;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(?string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }
}
