<?php

namespace App\Controller;

use App\Entity\Ouvrage;
use App\Repository\OuvrageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class OuvrageController extends AbstractController
{
    #[Route('/api/ouvrages/list', name: 'api_ouvrages_list', methods: ['GET'])]
    public function liste(OuvrageRepository $repo): JsonResponse
    {
        return $this->json($repo->findAll(), 200, [], ['groups' => 'ouvrage:read']);
    }

    #[Route('/api/ouvrages/add', name: 'api_ouvrages_add', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return $this->json(['message' => 'Données JSON invalides'], 400);
        }

        $ouvrage = new Ouvrage();
        $ouvrage->setCode($data['code'] ?? '');
        $ouvrage->setTitre($data['titre'] ?? '');
        $ouvrage->setDateEdition(new \DateTime($data['dateEdition'] ?? 'now'));

        $em->persist($ouvrage);
        $em->flush();

        return $this->json(['message' => 'Ouvrage créé !'], 201);
    }

    #[Route('/api/ouvrages/{id}', name: 'api_ouvrages_show', methods: ['GET'])]
    public function show(Ouvrage $ouvrage): JsonResponse
    {
        return $this->json($ouvrage, 200, [], ['groups' => 'ouvrage:read']);
    }

    #[Route('/api/ouvrages/edit/{id}', name: 'api_ouvrages_update', methods: ['PUT'])]
    public function update(Request $request, Ouvrage $ouvrage, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return $this->json(['message' => 'Données JSON invalides'], 400);
        }

        $ouvrage->setCode($data['code'] ?? $ouvrage->getCode());
        $ouvrage->setTitre($data['titre'] ?? $ouvrage->getTitre());
        $ouvrage->setDateEdition(new \DateTime($data['dateEdition'] ?? $ouvrage->getDateEdition()->format('Y-m-d')));

        $em->flush();

        return $this->json(['message' => 'Ouvrage modifié']);
    }

    #[Route('/api/ouvrages/delete/{id}', name: 'api_ouvrages_delete', methods: ['DELETE'])]
    public function delete(Ouvrage $ouvrage, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($ouvrage);
        $em->flush();

        return $this->json(['message' => 'Ouvrage supprimé']);
    }
}
