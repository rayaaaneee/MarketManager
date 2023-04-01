<?php

namespace App\Controller;

use App\Entity\ArticleInList;
use App\Entity\ShoppingList;
use App\Form\ShoppingListType;
use App\Repository\ShoppingListRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleInListRepository;
use InfiniteIterator;

#[Route('/list')]
class ShoppingListController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(ShoppingListRepository $shoppingListRepository, Session $session): Response
    {
        $listUserTotalPrice=0;
        $lowerPrice = 1000000000000000000;
        $higherPrice = -1;
        $nb = 0;
        $average =0;
        foreach($shoppingListRepository->findBy(['user'=>$session->get('id')]) as $listUser){
            $listUserTotalPrice += $listUser->getTotalPrice();
            foreach($listUser->getArticles() as $listArticle){
                $nb+=1;
                if ($listArticle->getUnityPrice() > $higherPrice) $higherPrice = $listArticle->getUnityPrice();
                if($listArticle->getUnityPrice()< $lowerPrice) $lowerPrice=$listArticle->getUnityPrice();
                
            }
        }
        $average = $listUserTotalPrice / $nb;
        return $this->render('list/list.html.twig', [
            // recupere que les listes de l'utilisateur connecté
            'shopping_lists' => $shoppingListRepository->findBy(['user' => $session->get('id')]),
        ]);
    }

    #[Route('/new', name: 'new_list', methods: ['GET', 'POST'])]
    public function newList(Request $request, UserRepository $userRepository, ShoppingListRepository $shoppingListRepository, Session $session): Response
    {
        $shoppingList = new ShoppingList();
        //recupere le user qui a les informations de session depuis le UserRepository
        $user = $userRepository->findUserConnected($session->get('id'));
        $shoppingList->setUser($user);
        $shoppingList->setNbArticles(0);
        $shoppingList->setTotalPrice(0);
        $form = $this->createForm(ShoppingListType::class, $shoppingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shoppingListRepository->save($shoppingList, true);

            return $this->redirectToRoute('list', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('list/list.new.html.twig', [
            'shopping_list' => $shoppingList,
            'ShoppingListform' => $form,
        ]);
    }

    #[Route('/{id}', name: 'list_show', methods: ['GET'])]
    public function show(ShoppingList $shoppingList): Response
    {
        $articles = $shoppingList->getArticles()->getValues();
        return $this->render('list/list.show.html.twig', [
            'shopping_list' => $shoppingList,
            'articles' => $articles
        ]);
    }

    #[Route('/{id}/edit', name: 'list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ShoppingList $shoppingList, ShoppingListRepository $shoppingListRepository): Response
    {
        $form = $this->createForm(ShoppingListType::class, $shoppingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shoppingListRepository->save($shoppingList, true);

            return $this->redirectToRoute('list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('list/list.edit.html.twig', [
            'shopping_list' => $shoppingList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'list_delete', methods: ['POST'])]
    public function delete(Request $request, ShoppingList $shoppingList, ShoppingListRepository $shoppingListRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $shoppingList->getId(), $request->request->get('_token'))) {
            $shoppingListRepository->remove($shoppingList, true);
        }

        return $this->redirectToRoute('list', [], Response::HTTP_SEE_OTHER);
    }
}
