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
    public function index(Session $session): Response
    {
        if (!$session->get('id')) {
            return $this->redirectToRoute('connect', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->render('home.html.twig', [
                'controller_name' => 'HomeController',
            ]);
        }
    }
}
