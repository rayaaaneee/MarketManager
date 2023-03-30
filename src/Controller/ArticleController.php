<?php

namespace App\Controller;

use App\Entity\ArticleInList;
use App\Repository\ArticleInListRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Type;
use App\Form\ArticleInListFormType;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Repository\ShoppingListRepository;
use App\Entity\ShoppingList;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'article')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        $classesTable = ['table-active', 'table-dark', 'table-primary', ''];
        $classesButtons = ['btn-outline-primary', 'btn-light', 'btn-dark', 'btn-primary'];
        return $this->render('article/article.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles,
            'classesTable' => $classesTable,
            'classesButtons' => $classesButtons,
            'i' => 0
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
    public function article(string $id, ArticleRepository $articleRepository, ShoppingListRepository $shoppingListRepository, ArticleInListRepository $articleInListRepository, Session $session, Request $request): Response | RedirectResponse
    {
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

            return $this->redirectToRoute('list_show', ['id' => $request["shoppingList"]]);
            exit;
        } else {

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
                'articleInListForm' => $articleInListForm->createView()
            ]);
        }
    }

    #[Route('/new', name: 'article_new')]
    public function newArticle(): Response
    {
        return $this->render('article/article.new.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
