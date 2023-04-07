<?php

namespace App\Controller;

use App\Entity\Collaborator;
use App\Form\CollaboratorType;
use App\Repository\CollaboratorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/collaborator')]
class CollaboratorController extends AbstractController
{
    #[Route('/', name: 'app_collaborator_index', methods: ['GET'])]
    public function index(CollaboratorRepository $collaboratorRepository): Response
    {
        return $this->render('collaborator/index.html.twig', [
            'collaborators' => $collaboratorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_collaborator_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CollaboratorRepository $collaboratorRepository): Response
    {
        $collaborator = new Collaborator();
        $form = $this->createForm(CollaboratorType::class, $collaborator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collaboratorRepository->save($collaborator, true);

            return $this->redirectToRoute('app_collaborator_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collaborator/new.html.twig', [
            'collaborator' => $collaborator,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collaborator_show', methods: ['GET'])]
    public function show(Collaborator $collaborator): Response
    {
        return $this->render('collaborator/show.html.twig', [
            'collaborator' => $collaborator,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_collaborator_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collaborator $collaborator, CollaboratorRepository $collaboratorRepository): Response
    {
        $form = $this->createForm(CollaboratorType::class, $collaborator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collaboratorRepository->save($collaborator, true);

            return $this->redirectToRoute('app_collaborator_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collaborator/edit.html.twig', [
            'collaborator' => $collaborator,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collaborator_delete', methods: ['POST'])]
    public function delete(Request $request, Collaborator $collaborator, CollaboratorRepository $collaboratorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collaborator->getId(), $request->request->get('_token'))) {
            $collaboratorRepository->remove($collaborator, true);
        }

        return $this->redirectToRoute('app_collaborator_index', [], Response::HTTP_SEE_OTHER);
    }
}
