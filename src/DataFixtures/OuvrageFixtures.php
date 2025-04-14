<?php

namespace App\DataFixtures;

use App\Entity\Ouvrage;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class OuvrageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ouvragesData = [
            ['code' => 'OUV001', 'titre' => 'Introduction à Symfony', 'date' => '2021-05-10'],
            ['code' => 'OUV002', 'titre' => 'Programmation en PHP', 'date' => '2020-03-15'],
            ['code' => 'OUV003', 'titre' => 'Base de données MySQL', 'date' => '2019-11-22'],
        ];

        foreach ($ouvragesData as $data) {
            $ouvrage = new Ouvrage();
            $ouvrage->setCode($data['code']);
            $ouvrage->setTitre($data['titre']);
            $ouvrage->setDateEdition(new \DateTime($data['date']));

            $manager->persist($ouvrage);
        }

        $manager->flush();
    }
}
