<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/article/search', name: 'article_search')]
    public function searchArticle(): Response
    {
        return $this->render('page/article.search.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/article/{id}', name: 'article')]
    public function article(string $id): Response
    {
        return $this->render('page/article.html.twig', [
            'controller_name' => 'HomeController',
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
