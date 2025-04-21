<?php

namespace App\DataFixtures;

use App\Entity\MotCle;
use App\Entity\MotCleOuvrage;
use App\Entity\Ouvrage;
use App\Repository\MotCleRepository;
use App\Repository\OuvrageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MotCleOuvrageFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private OuvrageRepository $ouvrageRepository,
        private MotCleRepository $motCleRepository
    ) {}
    public function load(ObjectManager $manager): void
    {
        // Récupérer tous les ouvrages et mots-clés
        $ouvrages = $this->ouvrageRepository->findAll();
        $motsCles = $this->motCleRepository->findAll();

        // Exemple de mapping entre ouvrage et mots-clés
        $associations = [
            'OUV001' => ['Symfony', 'Programmation', 'PHP'],
            'OUV002' => ['Programmation', 'PHP', 'Développement web'],
            'OUV003' => ['Base de données', 'MySQL', 'Technologie'],
        ];

        // Parcourir les associations et créer les MotCleOuvrage correspondants
        foreach ($associations as $ouvrageCode => $motCleLibelles) {
            // Récupérer l'ouvrage par son code
            $ouvrage = $this->findOuvrageByCode($ouvrages, $ouvrageCode);
            
            foreach ($motCleLibelles as $libelle) {
                // Récupérer le mot-clé par son libellé
                $motCle = $this->findMotCleByLibelle($motsCles, $libelle);

                // Créer la liaison MotCleOuvrage
                $motCleOuvrage = new MotCleOuvrage();
                $motCleOuvrage->setOuvrage($ouvrage);
                $motCleOuvrage->setMotCle($motCle);

                $manager->persist($motCleOuvrage);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OuvrageFixtures::class,
            MotCleFixtures::class,
        ];
    }

    /**
     * Fonction pour trouver un ouvrage par son code
     */
    private function findOuvrageByCode(array $ouvrages, string $code): ?Ouvrage
    {
        foreach ($ouvrages as $ouvrage) {
            if ($ouvrage->getCode() === $code) {
                return $ouvrage;
            }
        }
        return null;
    }

    /**
     * Fonction pour trouver un mot-clé par son libellé
     */
    private function findMotCleByLibelle(array $motsCles, string $libelle): ?MotCle
    {
        foreach ($motsCles as $motCle) {
            if ($motCle->getLibelle() === $libelle) {
                return $motCle;
            }
        }
        return null;
    }
}
