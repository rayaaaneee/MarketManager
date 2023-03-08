<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(SessionInterface $session): Response
    {
        $session->set('name', 'John Doe');
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/article/search', name: 'home')]
    public function searchArticle(SessionInterface $session): Response
    {
        dump($session->get('name'));
        return $this->render('page/article.search.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
