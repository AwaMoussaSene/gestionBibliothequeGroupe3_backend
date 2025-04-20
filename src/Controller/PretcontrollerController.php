<?php

namespace App\Controller;

use App\Entity\Pret;
use App\Enum\Status;
use App\Repository\PretRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class PretcontrollerController extends AbstractController
{
    //voirplus
    #[Route('/api/prets/{id}', name: 'liste_pret', methods: ['GET'])]
    public function listePret(
        int $id,
        PretRepository $pretRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $pret = $pretRepository->find($id);
    
        if (!$pret) {
            return new JsonResponse(['message' => 'Prêt non trouvé'], Response::HTTP_NOT_FOUND);
        }
    
        $exemplaire = $pret->getExemplaire();
        $livre = $exemplaire ? $exemplaire->getLivre() : null;
        $auteur = $livre && method_exists($livre, 'getAuteur') ? $livre->getAuteur() : null;
    
        $donnee = [
            'code_pret' => $pret->getId(),
            'titre_livre' => $livre ? $livre->getTitre() : 'N/A',
            'auteur' => $auteur ? $auteur->getNom() . ' ' . $auteur->getPrenom() : 'N/A',
            'date_demande' => $pret->getDateDemande()->format('Y-m-d'),
            'statut' => $pret->getStatut()->value
        ];
    
        return new JsonResponse($donnee, Response::HTTP_OK);
    }


// 



// accepter une demende
#[Route('/api/pret/{id}/accepter', name: 'accepter_pret', methods: ['PUT'])]
public function accepterPret(int $id, PretRepository $pretRepository, EntityManagerInterface $em): JsonResponse
{
    $pret = $pretRepository->find($id);

    if (!$pret) {
        return new JsonResponse(['message' => 'Prêt non trouvé'], Response::HTTP_NOT_FOUND);
    }

    if ($pret->getStatut() !== Status::EN_ATTENTE) {
        return new JsonResponse(['message' => 'Seuls les prêts en attente peuvent être acceptés'], Response::HTTP_BAD_REQUEST);
    }

    $pret->setStatut(Status::VALIDER);
    $pret->setDatePret(new \DateTime());

    $em->flush();

    return new JsonResponse(['message' => 'Prêt accepté avec succès.'], Response::HTTP_OK);
}

// refuser une demande

#[Route('/api/pret/{id}/refuser', name: 'refuser_pret', methods: ['PUT'])]
public function refuserPret(int $id, PretRepository $pretRepository, EntityManagerInterface $em): JsonResponse
{
    $pret = $pretRepository->find($id);

    if (!$pret) {
        return new JsonResponse(['message' => 'Prêt non trouvé'], Response::HTTP_NOT_FOUND);
    }

    if ($pret->getStatut() !== Status::EN_ATTENTE) {
        return new JsonResponse(['message' => 'Seuls les prêts en attente peuvent être refusés'], Response::HTTP_BAD_REQUEST);
    }

    $pret->setStatut(Status::REFUSER);

    $em->flush();

    return new JsonResponse(['message' => 'Prêt refusé avec succès.'], Response::HTTP_OK);
}



// Enregistrer un pret
#[Route('/api/prets/{id}/demarrer', name: 'demarrer_pret', methods: ['PUT'])]
public function demarrerPret(int $id, PretRepository $pretRepository, EntityManagerInterface $em): JsonResponse
{
    $pret = $pretRepository->find($id);

    if (!$pret) {
        return new JsonResponse(['message' => 'Prêt non trouvé'], Response::HTTP_NOT_FOUND);
    }

    if ($pret->getStatut() !== Status::VALIDER) {
        return new JsonResponse(['message' => 'Seuls les prêts validés peuvent être démarrés'], Response::HTTP_BAD_REQUEST);
    }

    $pret->setStatut(Status::EN_COUR);
    $pret->setDatePret(new \DateTime());
    $pret->setDateRetour((new \DateTime())->modify('+15 days')); // par ex, retour dans 15 jours

    $em->flush();

    return new JsonResponse(['message' => 'Le prêt est maintenant en cours'], Response::HTTP_OK);
}




//  lister toutes les pret 
#[Route('/api/prets', name: 'lister_prets', methods: ['GET'])]
public function listerPrets(PretRepository $pretRepository, SerializerInterface $serializer): JsonResponse
{
    $prets = $pretRepository->findAll();
    $jsonPrets = $serializer->serialize($prets, 'json', ['groups' => 'pret_read']);

    return new JsonResponse(json_decode($jsonPrets), Response::HTTP_OK);
}

//    liste des prets d'un adherant par l'adherant connecter
#[Route('/api/mes-prets', name: 'mes_prets', methods: ['GET'])]
public function mesPrets(Security $security, PretRepository $pretRepository, SerializerInterface $serializer): JsonResponse
{
    $user = $security->getUser();
    if (!$user) {
        return new JsonResponse(['message' => 'Utilisateur non connecté'], Response::HTTP_UNAUTHORIZED);
    }

    $prets = $pretRepository->findBy(['user' => $user]);
    $jsonPrets = $serializer->serialize($prets, 'json', ['groups' => 'pret_read']);

    return new JsonResponse(json_decode($jsonPrets), Response::HTTP_OK);
}

//enregistere le retour d'un pret
#[Route('/api/pret/{id}/retour', name: 'retour_pret', methods: ['PUT'])]
public function enregistrerRetourPret(int $id, PretRepository $pretRepository, EntityManagerInterface $em): JsonResponse
{
    $pret = $pretRepository->find($id);

    if (!$pret) {
        return new JsonResponse(['message' => 'Prêt non trouvé'], Response::HTTP_NOT_FOUND);
    }

    $aujourdhui = new \DateTime();
    $pret->setDateRetourReel($aujourdhui);

    // Vérifie si le retour est en retard
    if ($pret->getDateRetour() < $aujourdhui) {
        $pret->setStatut(Status::EN_RETARD);
    } else {
        $pret->setStatut(Status::RETOURNER);
    }

    $em->flush();

    return new JsonResponse([
        'message' => 'Retour de prêt enregistré',
        'statut' => $pret->getStatut()->value
    ], Response::HTTP_OK);
}


// lister   les pret d'un adherant par un rp 
#[Route('/api/prets/adherent/{id}', name: 'prets_adherent', methods: ['GET'])]
public function pretsAdherent(
    int $id,
    UserRepository $userRepository,
    PretRepository $pretRepository,
    SerializerInterface $serializer
): JsonResponse {
    $adherent = $userRepository->find($id);

    if (!$adherent) {
        return new JsonResponse(['message' => 'Adhérent non trouvé'], Response::HTTP_NOT_FOUND);
    }

    // // Optionnel : vérifier que l'utilisateur est bien un adhérent
    // if (!in_array('ADHERENT', $adherent->getRoles())) {
    //     return new JsonResponse(['message' => 'Ce n’est pas un adhérent'], Response::HTTP_BAD_REQUEST);
    // }

    $prets = $pretRepository->findBy(['user' => $adherent]);
    $jsonPrets = $serializer->serialize($prets, 'json', ['groups' => 'pret_read']);

    return new JsonResponse(json_decode($jsonPrets), Response::HTTP_OK);
}


}
