<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'app_user')]
#[ORM\UniqueConstraint(name: 'UNIQ_APP_USER_EMAIL', fields: ['email'])]
class User extends Personne implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(type: "json")]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER'; // Garantir que chaque utilisateur ait au moins un rôle "ROLE_USER"
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Effacez toute donnée temporaire sensible, le cas échéant
    }

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}
