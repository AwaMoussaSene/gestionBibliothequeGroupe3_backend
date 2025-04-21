<?php

namespace App\Controller;

use App\Entity\Rayon;
use App\Repository\RayonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class RayonController extends AbstractController
{
    #[Route('/rayons', name: 'get_rayons', methods: ['GET'])]
    public function getRayons(RayonRepository $rayonRepository): JsonResponse
    {
        $rayons = $rayonRepository->findAll();
        $data = [];
        foreach ($rayons as $rayon) {
            $data[] = [
                'id' => $rayon->getId(),
                'libelle' => $rayon->getLibelle(),
            ];
        }
        return $this->json($data);
    }

    #[Route('/rayon', name: 'add_rayon', methods: ['POST'])]
    public function addRayon(RayonRepository $rayonRepository, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['libelle'])) {
            return $this->json(['error' => 'Le libellé est obligatoire'], 400);
        }

        $rayon = new Rayon();
        $rayon->setLibelle($data['libelle']);

        $entityManager->persist($rayon);
        $entityManager->flush();

        return $this->json([
            'message' => 'Rayon créé avec succès',
            'id' => $rayon->getId(),
            'libelle' => $rayon->getLibelle(),
        ], 201);
    }

    #[Route('/rayons/{id}', name: 'update_rayon', methods: ['PUT'])]
    public function updateRayon(RayonRepository $rayonRepository, Request $request, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $rayon = $rayonRepository->find($id);

        if (!$rayon) {
            return $this->json(['error' => 'Rayon non trouvé'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['libelle'])) {
            $rayon->setLibelle($data['libelle']);
        }

        $entityManager->flush();

        return $this->json([
            'message' => 'Rayon mis à jour avec succès',
            'id' => $rayon->getId(),
            'libelle' => $rayon->getLibelle(),
        ]);
    }

    #[Route('/rayons/{id}', name: 'delete_rayon', methods: ['DELETE'])]
    public function deleteRayon(RayonRepository $rayonRepository, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $rayon = $rayonRepository->find($id);

        if (!$rayon) {
            return $this->json(['error' => 'Rayon non trouvé'], 404);
        }

        $entityManager->remove($rayon);
        $entityManager->flush();

        return $this->json(['message' => 'Rayon supprimé avec succès']);
    }
}
