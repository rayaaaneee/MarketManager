<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationFormType;
use App\Form\UserConnectionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;



class UserController extends AbstractController
{
    #[Route("/register", name:"user_register")]
    #[Route("/", name:"home")]
     
    public function register(Request $request,EntityManagerInterface $entityManager, Session $session)
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
    
            // rediriger vers une autre page ou afficher un message de succès
            return $this->redirectToRoute('home');
        }

        return $this->render('user/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route("/connect", name:"user_connection")]
    #[Route("/", name:"home")]
    public function connect(Request $request, EntityManagerInterface $entityManager, Session $session)
    {

        $form = $this->createForm(UserConnectionFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $formData = $form->getData();
            $user = $entityManager->getRepository(User::class)->findOneBy(['Surname' => $data->getSurname()]);
            if ($user && $user->getPassword() === $data->getPassword()) {
                $session->set('Name', $user->getName());
                $session->set('Surname', $user->getSurname());
                $session->set('id', $user->getId());
                $session->set('Password',$user->getPassword());
                $this->addFlash('success', 'Vous êtes connecté');
                return $this->redirectToRoute('home');
            } else {
                $this->addFlash('error', 'Identifiants incorrects');
                return $this->redirectToRoute('user_connection');
            }
        }
        return $this->render('user/connect.html.twig', [
            'connectionForm' => $form->createView(),
        ]);}

        #[Route("/disconnect", name:"user_disconnect")]
        #[Route("/", name:"home")]
        public function disconnect(Session $session)
        {
            $session->clear();
            return $this->redirectToRoute('home');
        }

}