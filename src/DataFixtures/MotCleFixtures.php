<?php

namespace App\DataFixtures;

use App\Entity\MotCle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MotCleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $motsCles = [
            'Programmation', 'Symfony', 'PHP', 'Base de données', 'MySQL',
            'Technologie', 'Mathématiques', 'Informatique', 'Développement web'
        ];

        foreach ($motsCles as $libelle) {
            $motCle = new MotCle();
            $motCle->setLibelle($libelle);

            $manager->persist($motCle);
        }

        $manager->flush();
    }
}
