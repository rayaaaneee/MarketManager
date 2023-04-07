<?php

namespace App\Controller;

use App\Entity\Collaborator;
use App\Repository\CollaboratorRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/collaborator')]
class CollaboratorController extends AbstractController
{
    #[Route('/{id}/delete', name: 'app_collaborator_delete', methods: ['POST'])]
    public function delete(int $id, CollaboratorRepository $collaboratorRepository): JsonResponse
    {
        $collaborator = $collaboratorRepository->find(['id' => $id]);
        $collaboratorRepository->remove($collaborator, true);
        return $this->json([
            'success' => true,
            'message' => 'Collaborator successfully deleted'
        ], 200);
    }

    #[Route('/{id}/delete', name: 'app_collaborator_delete', methods: ['GET'])]
    public function deleteGet(int $id, CollaboratorRepository $collaboratorRepository): RedirectResponse
    {
        $collaborator = $collaboratorRepository->find(['id' => $id]);
        $collaboratorRepository->remove($collaborator, true);
        return $this->redirectToRoute('list', [
            'quitted' => true
        ]);
    }
}
