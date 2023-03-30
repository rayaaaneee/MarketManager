<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stat')]
class StatController extends AbstractController
{
    #[Route('/', name: 'stat')]
    public function index(): Response
    {
        return $this->render('stat/stat.html.twig', [
            'controller_name' => 'StatController',
        ]);
    }
}
