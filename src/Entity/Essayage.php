<?php

namespace App\Entity;

use App\Repository\EssayageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EssayageRepository::class)
 */
class Essayage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $essaie;

    /**
     * @ORM\OneToOne(targetEntity=Adherent::class, inversedBy="essayage", cascade={"persist", "remove"})
     */
    private $adherent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEssaie(): ?bool
    {
        return $this->essaie;
    }

    public function setEssaie(?bool $essaie): self
    {
        $this->essaie = $essaie;

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
}
