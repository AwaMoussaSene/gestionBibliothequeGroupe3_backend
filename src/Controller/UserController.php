<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user') ,]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

   


    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        $user = new User();
        $user->setEmail($data['email']);
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setTelephone($data['telephone']);
        $role = $data['role'] ?? ' ADHERENT';
          $user->setRoles([$role]); // Assurez-vous que le rôle est valide
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
    
        $em->persist($user);
        $em->flush();
    
        return new JsonResponse(['message' => 'User registered successfully'], 201);
    }
    


    #[Route('/api/logout', name: 'api_logout', methods: ['POST'])]
    public function logout(): JsonResponse
    {
        return new JsonResponse([
            'message' => 'Déconnexion réussie. Supprimez le token côté client.'
        ]);
    }



    #[Route('/api/adherents', name: 'list_adherents', methods: ['GET'])]
public function listAdherents(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
{
    // On récupère tous les utilisateurs qui ont le rôle ADHERENT
    $adherents = $userRepository->findByRole('ADHERENT');

    // Sérialisation
    $jsonAdherents = $serializer->serialize($adherents, 'json', ['groups' => 'getusers']);

    return new JsonResponse(json_decode($jsonAdherents), Response::HTTP_OK);
}

}
