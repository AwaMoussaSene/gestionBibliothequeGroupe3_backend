<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;


final class AuteurcontrollerController extends AbstractController
{
   #[Route('/AuteurCreat', name: "createAuteur", methods: ['POST'])]
    public function createauteur(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        try {
            $auteur = $serializer->deserialize($request->getContent(), Auteur::class, 'json');
    
            $em->persist($auteur);
            $em->flush();
    
            $jsonauteur = $serializer->serialize($auteur, 'json', ['groups' => 'getauteurs']);
    
            return new JsonResponse(
                [
                    'message' => 'Auteur créé avec succès.',
                    'auteur' => json_decode($jsonauteur)
                ],
                Response::HTTP_CREATED
            );
    
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                    'message' => 'Erreur lors de la création de l\'auteur.',
                    'error' => $e->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
    

    #[Route('/api/auteur', name: 'app_auteur', methods:['GET'])]
    public function getAllauteur(AuteurRepository $auteurRepository,SerializerInterface $serializer): JsonResponse
    {

        // $this->denyAccessUnlessGranted('RB');
        $auteurList= $auteurRepository->findAll();
        $jsonauteurList = $serializer->serialize($auteurList, 'json');
        return new JsonResponse(
            [
                'message' => 'la liste des auteurs',
                'auteurs' => json_decode($jsonauteurList)
            ],
            Response::HTTP_OK
        );
        
    }


   #[Route('/api/deleteauteur/{id}', name: 'deleteAuteur', methods: ['DELETE'])]
    public function deleteAuteur(Auteur $auteur, EntityManagerInterface $em): JsonResponse 
    {

        // $this->denyAccessUnlessGranted('RB');
        $em->remove($auteur);
        $em->flush();

        
    return new JsonResponse(
        ['message' => 'Auteur supprimé avec succès',

        

    ],
        
        Response::HTTP_OK
    );
    }



    #[Route('/api/auteur/{id}', name: 'update_auteur', methods: ['PUT'])]
    public function updateAuteur(
        int $id,
        AuteurRepository $auteurRepo,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em
    ): JsonResponse {
        $auteur = $auteurRepo->find($id);
    
        if (!$auteur) {
            return new JsonResponse(['message' => 'Auteur non trouvé'], 404);
        }
    
        $serializer->deserialize(
            $request->getContent(),
            Auteur::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $auteur]
        );
    
        $em->persist($auteur);
        $em->flush();
    
        return new JsonResponse([
            'message' => 'Auteur mis à jour avec succès',
            'auteur' => [
                'id' => $auteur->getId(),
                'nom' => $auteur->getNom(),
                'prenom' => $auteur->getPrenom(),
                'telephone' => $auteur->getTelephone(),
                'profession' => $auteur->getProfession(),
            ]
        ], JsonResponse::HTTP_OK);
    }
    
}
