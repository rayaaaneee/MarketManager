<?php

namespace App\Controller;

use App\Entity\ArticleInList;
use App\Repository\ArticleInListRepository;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ArticleInListFormType;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\ShoppingListRepository;
use App\Form\ArticleType;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\FormInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Class\PaginatorManager\PaginatorManager;


#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'article', methods: ['GET', 'POST'])]
    public function index(ArticleRepository $articleRepository, TypeRepository $typeRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $requestPage = $request->query->getInt('p', 1);
        $pagination = $paginator->paginate(
            $articleRepository->findAllQuery(),
            $requestPage < 1 ? 1 : $requestPage,
            7
        );

        $types = $typeRepository->findAll();
        $formSearch = $this->createAndVerifyFormSearch($articleRepository, $types, $request);
        $articles = null;
        if ($formSearch["isSearch"]) {
            $articles = $formSearch["articles"];
        } else {
            $articles = $articleRepository->findAll();
        }
        $formSearch = $formSearch["formSearch"];
        $classesTable = ['table-active', ''];
        $classesButtons = ['btn-light', 'btn-primary'];
        return $this->render('article/article.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles,
            'classesTable' => $classesTable,
            'classesButtons' => $classesButtons,
            'i' => 0,
            'formSearch' => $formSearch->createView(),
            'pagination' => $pagination
        ]);
    }

    #[Route('/search', name: 'article_search')]
    public function searchArticle(): Response
    {
        return $this->render('article/article.search.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    // On precise que l'id est un parametre de la route et forcement un entier
    #[Route('/{id}', name: 'article_show', requirements: ['id' => '\d+'])]
    public function article(string $id, ArticleRepository $articleRepository, ShoppingListRepository $shoppingListRepository, ArticleInListRepository $articleInListRepository, TypeRepository $typeRepository, Session $session, Request $request): Response | RedirectResponse
    {
        $types = $typeRepository->findAll();
        if ($request->isMethod('POST')) {
            $articleInListInputBag = $request->request;
            $articleInListParameters = $articleInListInputBag->all();
            $request = $articleInListParameters["article_in_list_form"];

            $article = $articleRepository->find($id);
            $brand = null;
            if ($request["brand"] != "") {
                $brand = $request["brand"];
            }
            $totalPrice = $request["quantity"] * $request["unityPrice"];
            $shoppingList = $shoppingListRepository->find($request["shoppingList"]);

            $articleInList = new ArticleInList();
            $articleInList
                ->setName($request["name"])
                ->setQuantity($request["quantity"])
                ->setUnityPrice($request["unityPrice"])
                ->setShoppingList($shoppingList)
                ->setTotalPrice($totalPrice)
                ->setBrand($brand)
                ->setArticle($article);
            $articleInListRepository->save($articleInList, true);

            $totalArticles = $articleInList->getQuantity() + $shoppingList->getNbArticles();
            $shoppingList->setNbArticles($totalArticles);

            $totalPrice = $articleInList->getTotalPrice() + $shoppingList->getTotalPrice();
            $shoppingList->setTotalPrice($totalPrice);

            $shoppingListRepository->save($shoppingList, true);

            return $this->redirectToRoute('list_show', [
                'id' => $request["shoppingList"],
                'add' => true
            ]);
            exit;
        } else {
            $formSearch = $this->createAndVerifyFormSearch($articleRepository, $types, $request)["formSearch"];

            $shoppingLists = $shoppingListRepository->findBy(['user' => $session->get('id')]);

            $article = $articleRepository->find($id);

            $articleInList = new ArticleInList();
            $articleInList
                ->setName($article->getName())
                ->setQuantity(1)
                ->setUnityPrice($article->getUnityPrice());

            $articleInListForm = $this->createForm(ArticleInListFormType::class, $articleInList, [
                'action' => $this->generateUrl('article_show', ['id' => $id]),
                'method' => 'POST',
                'attr' => ['class' => 'form-inline'],
                'shopping_lists' => $shoppingLists
            ]);

            return $this->render('article/article.show.html.twig', [
                'controller_name' => 'ArticleController',
                'article' => $article,
                'articleInListForm' => $articleInListForm->createView(),
                'formSearch' => $formSearch->createView()
            ]);
        }
    }

    private function createAndVerifyFormSearch(ArticleRepository $articleRepository, array $types, Request $request): FormInterface | array
    {
        $formSearch = $this->createForm(ArticleType::class, null, [
            'types' => $types
        ]);

        $articles = null;
        $isSearch = false;
        $formSearch->handleRequest($request);
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            $isSearch = true;

            $data = $formSearch->getData();
            $articles = array();
            $articles = $articleRepository->findByNameAndType($data, $articleRepository);
        }
        return [
            "formSearch" => $formSearch,
            "articles" => $articles,
            "isSearch" => $isSearch
        ];
    }
}
