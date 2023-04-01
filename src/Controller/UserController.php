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
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    #[Route("/register", name: "register", methods: ["GET", "POST"])]
    public function register(Request $request, EntityManagerInterface $entityManager, Session $session)
    {
        $printMessage = false;
        $isSuccess = false;
        $message = "";

        $hasError = $request->query->get('error') == "1" ? true : false;

        if ($hasError) {
            $printMessage = true;
            $isSuccess = false;
            $message = "An error has occured.";
        }

        $user = new User();
        $form = $this->createForm(UserRegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // si le nom et le prenom sont déjà utilisés, on affiche un message d'erreur
                $formData = $form->getData();
                //hash le mot de passe
                $formData->setPassword(password_hash($formData->getPassword(), PASSWORD_DEFAULT));

                $alreadyConnected = $entityManager->getRepository(User::class)->findOneBy(['Surname' => $formData->getSurname()]) && $entityManager->getRepository(User::class)->findOneBy(
                    [
                        'Name' => $formData->getName(),
                        'Surname' => $formData->getSurname()
                    ]
                );
                if ($alreadyConnected) {
                    return $this->redirectToRoute('register', [
                        'exists' => true
                    ], Response::HTTP_SEE_OTHER);
                }
                $entityManager->persist($user);
                $entityManager->flush();
                $session->set('Name', $user->getName());
                $session->set('Surname', $user->getSurname());
                $session->set('id', $user->getId());
                $session->set('Password', $user->getPassword());

                // rediriger vers une autre page ou afficher un message de succès
                return $this->redirectToRoute('home');
            } else {
                $this->redirectToRoute('register', [
                    'error' => true
                ], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('account/register.html.twig', [
            'registrationForm' => $form->createView(),
            'printMessage' => $printMessage,
            'isSuccess' => $isSuccess,
            'message' => $message
        ]);
    }

    #[Route("/connect", name: "connect", methods: ["GET", "POST"])]
    public function connect(Request $request, EntityManagerInterface $entityManager, Session $session)
    {
        $printMessage = false;
        $isSuccess = false;
        $message = "";

        $isWrongPassword = $request->query->get('wrongPassword');
        $isUnknown = $request->query->get('unknown');
        $isDisconnected = $request->query->get('disconnected');

        if ($isWrongPassword) {
            $printMessage = true;
            $isSuccess = false;
            $message = "Password is incorrect.";
        } else if ($isUnknown) {
            $printMessage = true;
            $isSuccess = false;
            $message = "User unknown.";
        } else if ($isDisconnected) {
            $printMessage = true;
            $isSuccess = true;
            $message = "You have been disconnected.";
        }

        $form = $this->createForm(UserConnectionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $user = $entityManager->getRepository(User::class)->findOneBy(
                [
                    'Surname' => $data->getSurname(),
                    'Name' => $data->getName()
                ]
            );

            if (!$user) {
                return $this->redirectToRoute('connect', [
                    'unknown' => true
                ], Response::HTTP_SEE_OTHER);
            } else {
                // si le mot de passe est correct quand il est déhasher, on connecte l'utilisateur
                if (password_verify($data->getPassword(), $user->getPassword())) {
                    $session->set('Name', $user->getName());
                    $session->set('Surname', $user->getSurname());
                    $session->set('id', $user->getId());
                    $session->set('Password', $user->getPassword());
                    return $this->redirectToRoute('home', [
                        'connected' => true
                    ], Response::HTTP_SEE_OTHER);
                } else {
                    return $this->redirectToRoute('connect', [
                        'wrongPassword' => true
                    ], Response::HTTP_SEE_OTHER);
                }
            }
        }

        return $this->render('account/connect.html.twig', [
            'connectionForm' => $form->createView(),
            'printMessage' => $printMessage,
            'isSuccess' => $isSuccess,
            'message' => $message
        ]);
    }

    #[Route("/disconnect", name: "disconnect")]
    public function disconnect(Session $session)
    {
        $session->clear();
        return $this->redirectToRoute(
            'connect',
            [
                'disconnected' => true
            ],
            Response::HTTP_SEE_OTHER
        );
    }
}
