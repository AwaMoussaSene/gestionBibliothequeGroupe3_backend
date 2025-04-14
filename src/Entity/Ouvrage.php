<?php

namespace App\Entity;

use App\Repository\OuvrageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OuvrageRepository::class)]
class Ouvrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEdition = null;

    /**
     * @var Collection<int, Exemplaire>
     */
    #[ORM\OneToMany(targetEntity: Exemplaire::class, mappedBy: 'ouvrage')]
    private Collection $exemplaires;

    /**
     * @var Collection<int, MotCleOuvrage>
     */
    #[ORM\OneToMany(targetEntity: MotCleOuvrage::class, mappedBy: 'ouvrage')]
    private Collection $motCleOuvrages;

    /**
     * @var Collection<int, AuteurOuvrage>
     */
    #[ORM\OneToMany(targetEntity: AuteurOuvrage::class, mappedBy: 'ouvrage')]
    private Collection $auteurOuvrages;

    public function __construct()
    {
        $this->exemplaires = new ArrayCollection();
        $this->motCles = new ArrayCollection();
        $this->motCleOuvrages = new ArrayCollection();
        $this->auteurOuvrages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateEdition(): ?\DateTimeInterface
    {
        return $this->dateEdition;
    }

    public function setDateEdition(\DateTimeInterface $dateEdition): static
    {
        $this->dateEdition = $dateEdition;

        return $this;
    }

    /**
     * @return Collection<int, Exemplaire>
     */
    public function getExemplaires(): Collection
    {
        return $this->exemplaires;
    }

    public function addExemplaire(Exemplaire $exemplaire): static
    {
        if (!$this->exemplaires->contains($exemplaire)) {
            $this->exemplaires->add($exemplaire);
            $exemplaire->setOuvrage($this);
        }

        return $this;
    }

    public function removeExemplaire(Exemplaire $exemplaire): static
    {
        if ($this->exemplaires->removeElement($exemplaire)) {
            // set the owning side to null (unless already changed)
            if ($exemplaire->getOuvrage() === $this) {
                $exemplaire->setOuvrage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MotCleOuvrage>
     */
    public function getMotCleOuvrages(): Collection
    {
        return $this->motCleOuvrages;
    }

    public function addMotCleOuvrage(MotCleOuvrage $motCleOuvrage): static
    {
        if (!$this->motCleOuvrages->contains($motCleOuvrage)) {
            $this->motCleOuvrages->add($motCleOuvrage);
            $motCleOuvrage->setOuvrage($this);
        }

        return $this;
    }

    public function removeMotCleOuvrage(MotCleOuvrage $motCleOuvrage): static
    {
        if ($this->motCleOuvrages->removeElement($motCleOuvrage)) {
            // set the owning side to null (unless already changed)
            if ($motCleOuvrage->getOuvrage() === $this) {
                $motCleOuvrage->setOuvrage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AuteurOuvrage>
     */
    public function getAuteurOuvrages(): Collection
    {
        return $this->auteurOuvrages;
    }

    public function addAuteurOuvrage(AuteurOuvrage $auteurOuvrage): static
    {
        if (!$this->auteurOuvrages->contains($auteurOuvrage)) {
            $this->auteurOuvrages->add($auteurOuvrage);
            $auteurOuvrage->setOuvrage($this);
        }

        return $this;
    }

    public function removeAuteurOuvrage(AuteurOuvrage $auteurOuvrage): static
    {
        if ($this->auteurOuvrages->removeElement($auteurOuvrage)) {
            // set the owning side to null (unless already changed)
            if ($auteurOuvrage->getOuvrage() === $this) {
                $auteurOuvrage->setOuvrage(null);
            }
        }

        return $this;
    }

   
}
