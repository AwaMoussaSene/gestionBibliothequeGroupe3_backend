<?php

namespace App\Entity;

use App\Repository\MotCleOuvrageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotCleOuvrageRepository::class)]
class MotCleOuvrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'motCleOuvrages')]
    private ?Ouvrage $ouvrage = null;

    #[ORM\ManyToOne(inversedBy: 'motCleOuvrages')]
    private ?MotCle $motCle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOuvrage(): ?Ouvrage
    {
        return $this->ouvrage;
    }

    public function setOuvrage(?Ouvrage $ouvrage): static
    {
        $this->ouvrage = $ouvrage;

        return $this;
    }

    public function getMotCle(): ?MotCle
    {
        return $this->motCle;
    }

    public function setMotCle(?MotCle $motCle): static
    {
        $this->motCle = $motCle;

        return $this;
    }
}
