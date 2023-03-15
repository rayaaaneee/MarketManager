<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'article')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        $classesTable = ['table-active', 'table-dark', 'table-primary', ''];
        return $this->render('page/article.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles,
            'classesTable' => $classesTable,
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

    #[Route('/{id}', name: 'article_id')]
    public function article(string $id, ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->find($id);
        return $this->render('page/article.html.twig', [
            'controller_name' => 'HomeController',
            'article' => $article
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
