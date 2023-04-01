<?php

namespace App\Controller;

use App\Entity\ArticleInList;
use App\Form\ArticleInListType;
use App\Repository\ArticleInListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article/in/list')]
class ArticleInListController extends AbstractController
{
    #[Route('/', name: 'app_article_in_list_index', methods: ['GET'])]
    public function index(ArticleInListRepository $articleInListRepository): Response
    {
        return $this->render('article_in_list/index.html.twig', [
            'article_in_lists' => $articleInListRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article_in_list_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleInListRepository $articleInListRepository): Response
    {
        $articleInList = new ArticleInList();
        $form = $this->createForm(ArticleInListType::class, $articleInList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleInListRepository->save($articleInList, true);

            return $this->redirectToRoute('app_article_in_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article_in_list/new.html.twig', [
            'article_in_list' => $articleInList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_in_list_show', methods: ['GET'])]
    public function show(ArticleInList $articleInList): Response
    {
        return $this->render('article_in_list/show.html.twig', [
            'article_in_list' => $articleInList,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_in_list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ArticleInList $articleInList, ArticleInListRepository $articleInListRepository): Response
    {
        $form = $this->createForm(ArticleInListType::class, $articleInList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleInListRepository->save($articleInList, true);

            return $this->redirectToRoute('app_article_in_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article_in_list/edit.html.twig', [
            'article_in_list' => $articleInList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_in_list_delete', methods: ['POST'])]
    public function delete(Request $request, ArticleInList $articleInList, ArticleInListRepository $articleInListRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articleInList->getId(), $request->request->get('_token'))) {
            $articleInListRepository->remove($articleInList, true);
        }

        return $this->redirectToRoute('app_article_in_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
