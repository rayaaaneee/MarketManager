<?php

namespace App\Controller;

use App\Entity\ShoppingList;
use App\Form\ShoppingListType;
use App\Form\ModifyArticleInListFormType;
use App\Repository\ShoppingListRepository;
use App\Repository\ArticleInListRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

#[Route('/list')]
class ShoppingListController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(ShoppingListRepository $shoppingListRepository, Session $session): Response
    {
        $shopping_lists = $shoppingListRepository->findBy(['user' => $session->get('id')]);
        $new_lists = [];
        foreach ($shopping_lists as $shopping_list) {
            if (!$shopping_list->hasEndDate()) {
                array_push($new_lists, $shopping_list);
            } else {
                $endDate = DateTime::createFromInterface($shopping_list->getEndDate())->setTime(0, 0, 0);
                $now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                $now = $now->setTime(0, 0, 0);
                if ($endDate >= $now) {
                    array_push($new_lists, $shopping_list);
                }
            }
        }
        return $this->render('list/list.html.twig', [
            // recupere que les listes de l'utilisateur connecté
            'shopping_lists' => $new_lists,
            'canEdit' => true
        ]);
    }

    #[Route('/old', name: 'old_list', methods: ['GET'])]
    public function oldLists(ShoppingListRepository $shoppingListRepository, Session $session): Response
    {
        $shopping_lists = $shoppingListRepository->findBy(['user' => $session->get('id')]);
        $old_lists = [];
        foreach ($shopping_lists as $shopping_list) {
            if ($shopping_list->hasEndDate()) {
                $endDate = DateTime::createFromInterface($shopping_list->getEndDate())->setTime(0, 0, 0);
                $now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                $now = $now->setTime(0, 0, 0);
                if ($endDate < $now) {
                    array_push($old_lists, $shopping_list);
                }
            }
        }
        return $this->render('list/list.old.html.twig', [
            // recupere que les listes de l'utilisateur connecté
            'shopping_lists' => $old_lists,
            'canEdit' => false
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
            'shoppingListForm' => $form,
        ]);
    }

    #[Route('/{id}', name: 'list_show', methods: ['GET', 'POST'])]
    public function show(ShoppingList $shoppingList, Request $request, ShoppingListRepository $shoppingListRepository, ArticleInListRepository $articleInListRepository): Response
    {
        $canEdit = true;
        if ($shoppingList->hasEndDate()) {
            $endDate = DateTime::createFromInterface($shoppingList->getEndDate())->setTime(0, 0, 0);
            $now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
            $now = $now->setTime(0, 0, 0);
            if ($endDate < $now) {
                $canEdit = false;
            }
        }
        $articles = $shoppingList->getArticles()->getValues();

        $modifyForms = [];
        for ($i = 0; $i < count($articles); $i++) {
            $modifyForms[$i] = $this->createForm(ModifyArticleInListFormType::class, $articles[$i], [
                'id' => $articles[$i]->getId(),
            ]);
        }

        if ($request->isMethod('POST')) {
            $nameForm = $modifyForms[0]->getName();
            $this->saveArticle($request, $shoppingList, $shoppingListRepository, $articleInListRepository, $nameForm);
        }

        return $this->render('list/list.show.html.twig', [
            'shopping_list' => $shoppingList,
            'articles' => $articles,
            'canEdit' => $canEdit,
            'modifyForms' => array_map(function ($form) {
                return $form->createView();
            }, $modifyForms),
            'i' => 0
        ]);
    }

    private function saveArticle(Request $request, ShoppingList $shoppingList, ShoppingListRepository $shoppingListRepository, ArticleInListRepository $articleInListRepository, string $nameForm)
    {
        $data = $request->request->all()[$nameForm];

        $articleId =  $data['id'];

        $articleName = $data['name'];
        $articleQuantity = $data['quantity'];
        $articleUnityPrice = $data['unityPrice'];

        if ($this->verifyValues($articleName, $articleQuantity, $articleUnityPrice)) {
            $articleInList = $articleInListRepository->findOneBy(['id' => $articleId]);
            $articleInList->setQuantity($articleQuantity);
            $articleInList->setUnityPrice($articleUnityPrice);
            $articleInList->setName($articleName);
            $articleInList->setTotalPrice($articleQuantity * $articleUnityPrice);

            $articleInListRepository->save($articleInList, true);

            $shoppingListRepository->updateTotalPriceAndNbArticles($shoppingList, true);
        } else {
            $this->addFlash('error', 'Veuillez remplir tous les champs');
        }
    }

    private function verifyValues(string $articleName, string $articleQuantity, string $articleUnityPrice): bool
    {
        if (empty($articleName) || empty($articleQuantity) || empty($articleUnityPrice)) {
            return false;
        }
        return true;
    }

    #[Route('{id}/edit/', name: 'list_edit', methods: ['GET', 'POST'])]
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
            'shoppingListForm' => $form,
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
