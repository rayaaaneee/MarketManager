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
    public function index(Session $session, TypeRepository $typeRepository, Request $request): Response | RedirectResponse
    {
        $printMessage = false;
        $isSuccess = false;
        $message = '';

        $justConnected = $request->query->get('connected') == "1" ? true : false;

        if ($justConnected) {
            $printMessage = true;
            $isSuccess = true;
            $message = 'You successfully connected';
        }

        $types = $typeRepository->findAll();
        $formSearch = $this->createForm(ArticleType::class, null, [
            'types' => $types,
            'action' => $this->generateUrl('article', [], UrlGeneratorInterface::ABSOLUTE_URL)
        ]);
        return $this->render('home.html.twig', [
            'controller_name' => 'HomeController',
            'formSearch' => $formSearch->createView(),
            'printMessage' => $printMessage,
            'isSuccess' => $isSuccess,
            'message' => $message
        ]);
    }
}
