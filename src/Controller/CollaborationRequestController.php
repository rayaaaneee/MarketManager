<?php

namespace App\Controller;

use App\Entity\CollaborationRequest;
use App\Entity\Collaborator;
use App\Entity\User;
use App\Form\CollaborationRequestType;
use App\Repository\CollaborationRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/collaboration/request')]
class CollaborationRequestController extends AbstractController
{
    #[Route('/', name: 'app_collaboration_request_index', methods: ['GET'])]
    public function index(CollaborationRequestRepository $collaborationRequestRepository, Session $session, Request $request): Response
    {
        $printMessage = false;
        $isSuccess = false;
        $message = '';
        if ($request->query->get('accepted') == "1") {
            $printMessage = true;
            $isSuccess = true;
            $message = 'Collaboration request successfully accepted';
        } else if ($request->query->get('rejected') == "1") {
            $printMessage = true;
            $isSuccess = true;
            $message = 'Collaboration request successfully rejected';
        }

        $requests = $collaborationRequestRepository->findBy(['receiver' => $session->get('user')]);
        return $this->render('collaboration_request/index.html.twig', [
            'collaboration_requests' => $requests,
            'printMessage' => $printMessage,
            'isSuccess' => $isSuccess,
            'message' => $message
        ]);
    }

    #[Route('/{id}/accept', name: 'collaboration_request_accept', methods: ['GET', 'POST'])]
    public function accept(Session $session, EntityManagerInterface $entityManager, int $id): Response
    {
        $collaborationRequestRepository = $entityManager->getRepository(CollaborationRequest::class);
        $collaboratorRepository = $entityManager->getRepository(Collaborator::class);
        $userRepository = $entityManager->getRepository(User::class);
        $request = $collaborationRequestRepository->find(['id' => $id]);

        $collaborator = new Collaborator();
        $collaborator->setShoppingList($request->getShoppingList());
        $collaborator->setUser($userRepository->find(['id' => $session->get('user')->getId()]));


        $collaboratorRepository->save($collaborator, true);
        $collaborationRequestRepository->remove($request, true);

        return $this->redirectToRoute('app_collaboration_request_index', [
            'accepted' => true,
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/reject', name: 'collaboration_request_reject', methods: ['GET', 'POST'])]
    public function reject(EntityManagerInterface $entityManager, int $id): Response
    {
        $collaborationRequestRepository = $entityManager->getRepository(CollaborationRequest::class);
        $request = $collaborationRequestRepository->find(['id' => $id]);

        $collaborationRequestRepository->remove($request, true);

        return $this->redirectToRoute('app_collaboration_request_index', [
            'rejected' => true,
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/delete', name: 'app_collaboration_request_delete', methods: ['POST'])]
    public function delete(CollaborationRequestRepository $collaborationRequestRepository, CollaborationRequest $collaborationRequest): JsonResponse
    {
        $collaborationRequestRepository->remove($collaborationRequest, true);
        return $this->json(
            [
                'success' => true,
                'message' => 'Collaboration request successfully deleted'
            ],
            200
        );
    }
}
