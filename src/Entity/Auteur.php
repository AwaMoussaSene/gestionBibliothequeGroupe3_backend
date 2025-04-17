<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur extends Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $profession = null;

    /**
     * @var Collection<int, AuteurOuvrage>
     */
    #[ORM\OneToMany(targetEntity: AuteurOuvrage::class, mappedBy: 'auteur')]
    private Collection $auteurOuvrages;

    public function __construct()
    {
        $this->auteurOuvrages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): static
    {
        $this->profession = $profession;

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
            $auteurOuvrage->setAuteur($this);
        }

        return $this;
    }

    public function removeAuteurOuvrage(AuteurOuvrage $auteurOuvrage): static
    {
        if ($this->auteurOuvrages->removeElement($auteurOuvrage)) {
            // set the owning side to null (unless already changed)
            if ($auteurOuvrage->getAuteur() === $this) {
                $auteurOuvrage->setAuteur(null);
            }
        }

        return $this;
    }
}
