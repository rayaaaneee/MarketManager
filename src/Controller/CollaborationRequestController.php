<?php

namespace App\Controller;

use App\Entity\CollaborationRequest;
use App\Form\CollaborationRequestType;
use App\Repository\CollaborationRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/collaboration/request')]
class CollaborationRequestController extends AbstractController
{
    #[Route('/', name: 'app_collaboration_request_index', methods: ['GET'])]
    public function index(CollaborationRequestRepository $collaborationRequestRepository): Response
    {
        return $this->render('collaboration_request/index.html.twig', [
            'collaboration_requests' => $collaborationRequestRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_collaboration_request_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CollaborationRequestRepository $collaborationRequestRepository): Response
    {
        $collaborationRequest = new CollaborationRequest();
        $form = $this->createForm(CollaborationRequestType::class, $collaborationRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collaborationRequestRepository->save($collaborationRequest, true);

            return $this->redirectToRoute('app_collaboration_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collaboration_request/new.html.twig', [
            'collaboration_request' => $collaborationRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collaboration_request_show', methods: ['GET'])]
    public function show(CollaborationRequest $collaborationRequest): Response
    {
        return $this->render('collaboration_request/show.html.twig', [
            'collaboration_request' => $collaborationRequest,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_collaboration_request_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CollaborationRequest $collaborationRequest, CollaborationRequestRepository $collaborationRequestRepository): Response
    {
        $form = $this->createForm(CollaborationRequestType::class, $collaborationRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collaborationRequestRepository->save($collaborationRequest, true);

            return $this->redirectToRoute('app_collaboration_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collaboration_request/edit.html.twig', [
            'collaboration_request' => $collaborationRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collaboration_request_delete', methods: ['POST'])]
    public function delete(Request $request, CollaborationRequest $collaborationRequest, CollaborationRequestRepository $collaborationRequestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collaborationRequest->getId(), $request->request->get('_token'))) {
            $collaborationRequestRepository->remove($collaborationRequest, true);
        }

        return $this->redirectToRoute('app_collaboration_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
