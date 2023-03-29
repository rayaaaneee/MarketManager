<?php

namespace App\Controller;

use App\Entity\ArticleInList;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Type;
use App\Form\ArticleInListFormType;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'article')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        $classesTable = ['table-active', 'table-dark', 'table-primary', ''];
        $classesButtons = ['btn-outline-primary', 'btn-light', 'btn-dark', 'btn-primary'];
        return $this->render('page/article.html.twig', [
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
        return $this->render('page/article.search.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    // On precise que l'id est un parametre de la route et forcement un entier
    #[Route('/{id}', name: 'article_show', requirements: ['id' => '\d+'])]
    public function article(string $id, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleInListFormType::class);
        $article = $articleRepository->find($id);

        $articleInList = new ArticleInList();
        $articleInListForm = $this->createForm(ArticleInListFormType::class, $articleInList);


        return $this->render('page/article.show.html.twig', [
            'controller_name' => 'ArticleController',
            'article' => $article,
            'articleInListForm' => $articleInListForm->createView()
        ]);
    }

    #[Route('article/new', name: 'article_new')]
    public function newArticle(): Response
    {
        return $this->render('page/article.new.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    }
