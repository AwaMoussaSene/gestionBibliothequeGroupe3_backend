<?php

namespace App\DataFixtures;

use App\Entity\Rayon;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RayonFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rayons = ['Littérature', 'Sciences', 'Histoire', 'Informatique'];

        foreach ($rayons as $libelle) {
            $rayon = new Rayon();
            $rayon->setLibelle($libelle);
            $manager->persist($rayon);
        }

        $manager->flush();
    }
}
