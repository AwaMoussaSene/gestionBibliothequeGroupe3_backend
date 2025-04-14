<?php

namespace App\Entity;

use App\Repository\MotCleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotCleRepository::class)]
class MotCle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, MotCleOuvrage>
     */
    #[ORM\OneToMany(targetEntity: MotCleOuvrage::class, mappedBy: 'motCle')]
    private Collection $motCleOuvrages;

    public function __construct()
    {
        $this->ouvrages = new ArrayCollection();
        $this->motCleOuvrages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

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
            $motCleOuvrage->setMotCle($this);
        }

        return $this;
    }

    public function removeMotCleOuvrage(MotCleOuvrage $motCleOuvrage): static
    {
        if ($this->motCleOuvrages->removeElement($motCleOuvrage)) {
            // set the owning side to null (unless already changed)
            if ($motCleOuvrage->getMotCle() === $this) {
                $motCleOuvrage->setMotCle(null);
            }
        }

        return $this;
    }


}
