<?php

namespace App\Entity;

use App\Repository\AuteurOuvrageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuteurOuvrageRepository::class)]
class AuteurOuvrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'auteurOuvrages')]
    private ?Auteur $auteur = null;

    #[ORM\ManyToOne(inversedBy: 'auteurOuvrages')]
    private ?Ouvrage $ouvrage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
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
}
