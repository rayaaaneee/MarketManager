<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Session $session, TypeRepository $typeRepository): Response | RedirectResponse
    {
        $types = $typeRepository->findAll();
        $formSearch = $this->createForm(ArticleType::class, null, [
            'types' => $types,
            'action' => $this->generateUrl('article', [], UrlGeneratorInterface::ABSOLUTE_URL)
        ]);
        if (!$session->get('id')) {
            return $this->redirectToRoute('connect', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->render('home.html.twig', [
                'controller_name' => 'HomeController',
                'formSearch' => $formSearch->createView()
            ]);
        }
    }
}
