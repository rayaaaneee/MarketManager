<?php

namespace App\Controller;

use App\Entity\Collaborator;
use App\Repository\CollaboratorRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/collaborator')]
class CollaboratorController extends AbstractController
{
    #[Route('/{id}/delete', name: 'app_collaborator_delete', methods: ['POST'])]
    public function index(int $id, CollaboratorRepository $collaboratorRepository): JsonResponse
    {
        $collaborator = $collaboratorRepository->find(['id' => $id]);
        $collaboratorRepository->remove($collaborator, true);
        return $this->json([
            'success' => true,
            'message' => 'Collaborator successfully deleted'
        ], 200);
    }
}
