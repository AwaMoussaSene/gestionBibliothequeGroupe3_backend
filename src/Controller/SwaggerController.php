<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Contrôleur pour la documentation Swagger UI
 */
class SwaggerController extends AbstractController
{
    #[Route('/api/doc', name: 'app_swagger_ui')]
    public function index(): Response
    {
        // Rendre le template Twig qui affiche l'interface Swagger UI
        return $this->render('swagger/index.html.twig');
    }

    #[Route('/api/doc.json', name: 'app_swagger_json', methods: ['GET'])]
    public function jsonSpec(): JsonResponse
    {
        // Rediriger vers le fichier API JSON généré par NelmioApiDocBundle
        return $this->redirect('/nelmio-api-doc.json');
    }
}
