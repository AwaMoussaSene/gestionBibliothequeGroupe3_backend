<?php

namespace App\DataFixtures;

use App\Entity\User;
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


        // 🔹 Création des autres utilisateurs (RP, RB, ADHERENT) avec mots de passe connus
        // $roles = ['RP', 'RB', 'ADHERENT'];
        $ADHERENT = new User();
        $ADHERENT->setNom('Coly');
        $ADHERENT->setPrenom('admin');
        $ADHERENT->setEmail('visit@gmail.com');
        $ADHERENT->setTelephone('+221774003030');
        $ADHERENT->setRoles(['ADHERENT']);
        
        $hashedPassword = $this->passwordHasher->hashPassword($ADHERENT, 'visit@123');
        $ADHERENT->setPassword($hashedPassword);
        
        $manager->persist($ADHERENT);
        
        // 🔹 Utilisateur RP
        $rp = new User();
        $rp->setNom('Sarr');
        $rp->setPrenom('responsable pédagogique');
        $rp->setEmail('rp@gmail.com');
        $rp->setTelephone('+221770000111');
        $rp->setRoles(['RP']);
        
        $hashedPassword = $this->passwordHasher->hashPassword($rp, 'rp@123');
        $rp->setPassword($hashedPassword);
        
        $manager->persist($rp);
        
        // 🔹 Utilisateur RB
        $rb = new User();
        $rb->setNom('Fall');
        $rb->setPrenom('responsable bureau');
        $rb->setEmail('rb@gmail.com');
        $rb->setTelephone('+221770000222');
        $rb->setRoles(['RB']);
        
        $hashedPassword = $this->passwordHasher->hashPassword($rb, 'rb@123');
        $rb->setPassword($hashedPassword);
        
        $manager->persist($rb);
        

        $manager->flush();
    }
}
