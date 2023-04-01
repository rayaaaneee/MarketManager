<?php

namespace App\Controller;

use App\Entity\ArticleInList;
use App\Form\ArticleInListType;
use App\Repository\ArticleInListRepository;
use App\Repository\ShoppingListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/articleInList')]
class ArticleInListController extends AbstractController
{
    #[Route('/{id}', name: 'app_article_in_list_delete_page', methods: ['GET'])]
    public function show(ArticleInList $articleInList): Response
    {
        $shoppingList = $articleInList->getShoppingList();
        return $this->render('article_in_list/article_in_list.delete.html.twig', [
            'article' => $articleInList,
            'shopping_list' => $shoppingList,
        ]);
    }

    #[Route('/{id}', name: 'app_article_in_list_delete', methods: ['POST'])]
    public function delete(Request $request, ArticleInList $articleInList, ArticleInListRepository $articleInListRepository, ShoppingListRepository $shoppingListRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $articleInList->getId(), $request->request->get('_token'))) {
            $articleInListRepository->remove($articleInList, true);
            $shoppingList = $articleInList->getShoppingList();
            $shoppingListRepository->updateTotalPriceAndNbArticles($shoppingList, true);
        }

        return $this->redirectToRoute('list_show', [
            'id' => $articleInList->getShoppingList()->getId(),
            'delete' => true
        ], Response::HTTP_SEE_OTHER);
    }
}
