<?php

namespace App\Controller;

use App\Entity\ShoppingList;
use App\Form\ArticleInListType;
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
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormInterface;
use App\Form\UserAsCollaboratorType;
use DateTime;


#[Route('/list')]
class ShoppingListController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(ShoppingListRepository $shoppingListRepository, Session $session, Request $request): Response
    {
        $printMessage = false;
        $isSuccess = false;
        $message = "";

        $isEdited = $request->query->get('edited') == "1" ? true : false;
        $isCreated = $request->query->get('created') == "1" ? true : false;
        $isDeleted = $request->query->get('deleted') == "1" ? true : false;
        if ($isEdited) {
            $printMessage = true;
            $isSuccess = true;
            $message = "List successfully edited";
        } else if ($isCreated) {
            $printMessage = true;
            $isSuccess = true;
            $message = "List successfully created";
        } else if ($isDeleted) {
            $printMessage = true;
            $isSuccess = true;
            $message = "List successfully deleted";
        }


        $shopping_lists = $shoppingListRepository->findBy(['user' => $session->get('id')]);
        $new_lists = [];
        $totalPriceList = 0;
        $nbItems = 0;
        foreach ($shopping_lists as $shopping_list) {
            if (!$shopping_list->hasEndDate()) {
                array_push($new_lists, $shopping_list);
                $totalPriceList += $shopping_list->getTotalPrice();
                $nbItems += $shopping_list->getNbArticles();
            } else {
                $endDate = DateTime::createFromInterface($shopping_list->getEndDate())->setTime(0, 0, 0);
                $now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                $now = $now->setTime(0, 0, 0);
                if ($endDate >= $now) {
                    array_push($new_lists, $shopping_list);
                    $totalPriceList += $shopping_list->getTotalPrice();
                    $nbItems += $shopping_list->getNbArticles();
                }
            }
        }
        return $this->render('list/list.html.twig', [
            // recupere que les listes de l'utilisateur connecté
            'shopping_lists' => $new_lists,
            'canEdit' => true,
            'printMessage' => $printMessage,
            'isSuccess' => $isSuccess,
            'message' => $message,
            'totalPriceList' => $totalPriceList,
            'nbItems' => $nbItems
        ]);
    }

    #[Route('/old', name: 'old_list', methods: ['GET'])]
    public function oldLists(ShoppingListRepository $shoppingListRepository, Session $session): Response
    {
        $shopping_lists = $shoppingListRepository->findBy(['user' => $session->get('id')]);
        $old_lists = [];
        $totalPriceList = 0;
        $nbItems = 0;
        foreach ($shopping_lists as $shopping_list) {
            if ($shopping_list->hasEndDate()) {
                $endDate = DateTime::createFromInterface($shopping_list->getEndDate())->setTime(0, 0, 0);
                $now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                $now = $now->setTime(0, 0, 0);
                if ($endDate < $now) {
                    if ($shopping_list->getNbArticles() === 0) {
                        $shoppingListRepository->remove($shopping_list, true);
                        continue;
                    }
                    array_push($old_lists, $shopping_list);
                    $totalPriceList += $shopping_list->getTotalPrice();
                    $nbItems += $shopping_list->getNbArticles();
                }
            }
        }
        return $this->render('list/list.old.html.twig', [
            // recupere que les listes de l'utilisateur connecté
            'shopping_lists' => $old_lists,
            'canEdit' => false,
            'totalPriceList' => $totalPriceList,
            'nbItems' => $nbItems
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

            return $this->redirectToRoute('list', [
                'created' => true
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('list/list.new.html.twig', [
            'shopping_list' => $shoppingList,
            'shoppingListForm' => $form,
        ]);
    }

    #[Route('/{id}', name: 'list_show', methods: ['GET', 'POST'])]
    public function show(ShoppingList $shoppingList, Request $request, ShoppingListRepository $shoppingListRepository, ArticleInListRepository $articleInListRepository, PaginatorInterface $paginator): Response
    {
        $addCollaboratorForm = $this->createFormAddCollaborator();

        $requestPage = $request->query->getInt('p', 1);
        $pagination = $paginator->paginate(
            $articleInListRepository->findByAllByShoppingListQuery($shoppingList),
            $requestPage < 1 ? 1 : $requestPage,
            4
        );

        $printMessage = false;
        $isSuccess = false;
        $message = "";

        $added = $request->query->get('add') == "1" ? true : false;
        $deleted = $request->query->get('delete') == "1" ? true : false;
        if ($added) {
            $printMessage = true;
            $isSuccess = true;
            $message = "Article added successfully";
        } else if ($deleted) {
            $printMessage = true;
            $isSuccess = true;
            $message = "Article deleted successfully";
        }

        if ($request->isMethod('POST')) {
            $inputBag = $request->request;
            $nameForm = $inputBag->keys()[0];
            $this->saveArticle($request, $shoppingList, $shoppingListRepository, $articleInListRepository, $nameForm);
            $printMessage = true;
            $isSuccess = true;
            $message = "Article modifié avec succès";
        }

        $articles = $pagination->getItems();

        $modifyForms = [];
        for ($i = 0; $i < count($articles); $i++) {
            $modifyForms[$i] = $this->createForm(
                ModifyArticleInListFormType::class,
                $articles[$i],
                [
                    'id' => $articles[$i]->getId(),
                ]
            );
        }

        $oldList = false;
        if ($shoppingList->hasEndDate()) {
            $endDate = DateTime::createFromInterface($shoppingList->getEndDate())->setTime(0, 0, 0);
            $now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
            $now = $now->setTime(0, 0, 0);
            if ($endDate < $now) {
                $oldList = true;
            }
        }

        return $this->render('list/list.show.html.twig', [
            'shopping_list' => $shoppingList,
            'articles' => $articles,
            'oldList' => $oldList,
            'i' => 0,
            'modifyForms' => array_map(function ($form) {
                return $form->createView();
            }, $modifyForms),
            'printMessage' => $printMessage,
            'isSuccess' => $isSuccess,
            'message' => $message,
            'pagination' => $pagination,
            'addCollaboratorForm' => $addCollaboratorForm->createView(),
        ]);
    }

    private function createFormAddCollaborator(): FormInterface
    {
        $form = $this->createForm(UserAsCollaboratorType::class);
        return $form;
    }

    #[Route('/{id}/stat', name: 'list_show_stat', methods: ['GET', 'POST'])]
    public function show_stat(ShoppingList $shoppingList): Response
    {
        $data = [];
        $ArticlesOfList = $shoppingList->getArticles();
        foreach ($ArticlesOfList as $articleInList) {
            $nameTypeArticle = $articleInList->getArticle()->getType()->getName();
            if (!(in_array($nameTypeArticle, $data))) {
                array_push($data, $nameTypeArticle);
            }
        }

        $associated_tab = array();
        foreach ($data as $type) {
            $associated_tab[$type] = 0;
        }

        foreach ($ArticlesOfList as $articleInList) {
            $nameTypeArticle = $articleInList->getArticle()->getType()->getName();
            $associated_tab[$nameTypeArticle] += $articleInList->getQuantity();
        }

        $lowerPrice = 1000000000000000000;
        $higherPrice = -1;

        foreach ($shoppingList->getArticles() as $listArticle) {
            if ($listArticle->getUnityPrice() > $higherPrice) $higherPrice = $listArticle->getUnityPrice();
            if ($listArticle->getUnityPrice() < $lowerPrice) $lowerPrice = $listArticle->getUnityPrice();
        }

        $finalTab = [];
        array_push($finalTab, $lowerPrice);
        array_push($finalTab, $higherPrice);
        return $this->render('list/list.stat.html.twig', [
            "shoppingList" => $shoppingList,
            'controller_name' => 'StatController',
            'data' => $associated_tab,
            'stats' => $finalTab,
        ]);
    }

    private function saveArticle(Request $request, ShoppingList $shoppingList, ShoppingListRepository $shoppingListRepository, ArticleInListRepository $articleInListRepository, string $nameForm): void
    {
        $data = $request->request->all()[$nameForm];

        $articleId =  $data['id'];

        $articleName = $data['name'];
        $articleQuantity = intval($data['quantity']);
        $articleUnityPrice = floatval($data['unityPrice']);
        $articleBrand = $data['brand'];

        $articleInList = $articleInListRepository->findOneBy(['id' => $articleId]);
        if (empty($articleName)) {
            $articleName = $articleInList->getArticle()->getName();
        }
        if (empty($articleQuantity) || $articleQuantity < 0 || $articleQuantity > 1000 || $articleQuantity < 1) {
            $articleQuantity = 1;
        }
        if (empty($articleUnityPrice) || $articleUnityPrice < 0) {
            $articleUnityPrice = $articleInList->getArticle()->getUnityPrice();
        }
        $articleInList->setQuantity($articleQuantity);
        $articleInList->setUnityPrice($articleUnityPrice);
        $articleInList->setName($articleName);
        $articleInList->setTotalPrice($articleQuantity * $articleUnityPrice);
        $articleInList->setBrand($articleBrand);

        $articleInListRepository->save($articleInList, true);

        $shoppingListRepository->updateTotalPriceAndNbArticles($shoppingList, true);
    }


    #[Route('/edit/{id}', name: 'list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ShoppingList $shoppingList, ShoppingListRepository $shoppingListRepository): Response
    {
        $form = $this->createForm(ShoppingListType::class, $shoppingList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $shoppingListRepository->save($shoppingList, true);

            return $this->redirectToRoute('list', [
                'edited' => true
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('list/list.edit.html.twig', [
            'shopping_list' => $shoppingList,
            'shoppingListForm' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'list_delete', methods: ['POST'])]
    public function delete(Request $request, ShoppingList $shoppingList, ShoppingListRepository $shoppingListRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $shoppingList->getId(), $request->request->get('_token'))) {
            $shoppingListRepository->remove($shoppingList, true);
        }

        return $this->redirectToRoute('list', [
            'deleted' => true
        ], Response::HTTP_SEE_OTHER);
    }
}
