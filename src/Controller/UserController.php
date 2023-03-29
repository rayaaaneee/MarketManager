<?php

namespace App\Controller;

use App\Entity\ShoppingList;
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
    #[Route("/register", name: "register")]
    public function register(Request $request, EntityManagerInterface $entityManager, Session $session)
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // si le nom et le prenom sont déjà utilisés, on affiche un message d'erreur
            $formData = $form->getData();
            //hash le mot de passe
            $formData->setPassword(password_hash($formData->getPassword(), PASSWORD_DEFAULT));

            $alreadyConnected = $entityManager->getRepository(User::class)->findOneBy(['Surname' => $formData->getSurname()]) && $entityManager->getRepository(User::class)->findOneBy(['Name' => $formData->getName()]);
            if ($alreadyConnected) {
                $this->addFlash('error', 'Ce nom est déjà utilisé');
                return $this->redirectToRoute('register');
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $session->set('Name', $user->getName());
            $session->set('Surname', $user->getSurname());
            $session->set('id', $user->getId());
            $session->set('Password', $user->getPassword());

            // rediriger vers une autre page ou afficher un message de succès
            return $this->redirectToRoute('home');
        }

        return $this->render('page/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route("/connect", name: "connect")]
    public function connect(Request $request, EntityManagerInterface $entityManager, Session $session)
    {

        $form = $this->createForm(UserConnectionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $formData = $form->getData();
            $user = $entityManager->getRepository(User::class)->findOneBy(['Surname' => $data->getSurname()]);
            // si le mot de passe est correct quand il est déhasher, on connecte l'utilisateur
            if (password_verify($formData->getPassword(), $user->getPassword())) {
                $session->set('Name', $user->getName());
                $session->set('Surname', $user->getSurname());
                $session->set('id', $user->getId());
                $session->set('Password', $user->getPassword());
                return $this->redirectToRoute('home');
            } else {
                return $this->redirectToRoute('connect');
            }
        }

        return $this->render('page/connect.html.twig', [
            'connectionForm' => $form->createView(),
        ]);
    }

    #[Route("/disconnect", name: "disconnect")]
    public function disconnect(Session $session)
    {
        $session->clear();
        return $this->redirectToRoute('connect');
    }
}
