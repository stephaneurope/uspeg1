<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdherentRepository")
 */
class Adherent
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
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $born;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subCategory;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $toNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sex;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $complement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $record;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $licenceType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $homePhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobilePhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categoryArbitre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $placeOfBirth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $clubChange;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $clubOut;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="adherent")
     */
    private $commandes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Amount", mappedBy="adherent")
     */
    private $amounts;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->amounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBorn(): ?\DateTimeInterface
    {
        return $this->born;
    }

    public function setBorn(?\DateTimeInterface $born): self
    {
        $this->born = $born;

        return $this;
    }

    public function getSubCategory(): ?string
    {
        return $this->subCategory;
    }

    public function setSubCategory(?string $subCategory): self
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    public function getToNumber(): ?int
    {
        return $this->toNumber;
    }

    public function setToNumber(?int $toNumber): self
    {
        $this->toNumber = $toNumber;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(?string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function setComplement(?string $complement): self
    {
        $this->complement = $complement;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLieut(): ?string
    {
        return $this->lieut;
    }

    public function setLieut(?string $lieut): self
    {
        $this->lieut = $lieut;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getRecord(): ?\DateTimeInterface
    {
        return $this->record;
    }

    public function setRecord(?\DateTimeInterface $record): self
    {
        $this->record = $record;

        return $this;
    }

    public function getLicenceType(): ?string
    {
        return $this->licenceType;
    }

    public function setLicenceType(?string $licenceType): self
    {
        $this->licenceType = $licenceType;

        return $this;
    }

    public function getHomePhone(): ?string
    {
        return $this->homePhone;
    }

    public function setHomePhone(?string $homePhone): self
    {
        $this->homePhone = $homePhone;

        return $this;
    }

    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    public function setMobilePhone(?string $mobilePhone): self
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCategoryArbitre(): ?string
    {
        return $this->categoryArbitre;
    }

    public function setCategoryArbitre(?string $categoryArbitre): self
    {
        $this->categoryArbitre = $categoryArbitre;

        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(?string $placeOfBirth): self
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    public function getClubChange(): ?string
    {
        return $this->clubChange;
    }

    public function setClubChange(?string $clubChange): self
    {
        $this->clubChange = $clubChange;

        return $this;
    }

    public function getClubOut(): ?string
    {
        return $this->clubOut;
    }

    public function setClubOut(?string $clubOut): self
    {
        $this->clubOut = $clubOut;

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
            $commande->setAdherent($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getAdherent() === $this) {
                $commande->setAdherent(null);
            }
        }

        return $this;
    }
    
     /**
     * @return Collection|Amount[]
     */
    public function getAmounts(): Collection
    {
        return $this->amounts;
    }

   
    public function setAmounts(?Amount $amounts): self
    {
        $this->amounts = $amounts;

        return $this;
    }

     public function addAmount(Amount $amount): self
    {
        if (!$this->amounts->contains($amount)) {
            $this->amounts[] = $amount;
            $amount->setAdherent($this);
        }

        return $this;
    }

    public function removeAmount(Amount $amount): self
    {
        if ($this->amounts->contains($amount)) {
            $this->amounts->removeElement($amount);
            // set the owning side to null (unless already changed)
            if ($amount->getAdherent() === $this) {
                $amount->setAdherent(null);
            }
        }

        return $this;
    }
}
