<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Auteur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // 🔹 Création d'utilisateurs pour chaque rôle spécifique
        $roles = [
            'ROLE_VISITEUR',
            'ROLE_RP',
            'ROLE_RB',
            'ROLE_ADHERENT'
        ];

        foreach ($roles as $role) {
            $user = new User();
            $user->setNom("Nom $role")
                ->setPrenom("Prénom $role")
                ->setTelephone("770000000")
                ->setEmail(strtolower($role) . '@test.com')
                ->setRoles([$role]);

            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        // 🔹 Création de 10 utilisateurs génériques avec le rôle ROLE_VISITEUR
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setNom('Nom ' . $i);
            $user->setPrenom('Prenom ' . $i);
            $user->setTelephone('77000000' . $i);
            $user->setEmail('user' . $i . '@example.com');
            $user->setRoles(['ROLE_VISITEUR']);

            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        
    }
}
