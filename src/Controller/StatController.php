<?php

namespace App\Controller;

use App\Repository\ShoppingListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/stat')]
class StatController extends AbstractController
{
    #[Route('/', name: 'stat')]
    public function index(ShoppingListRepository $shoppingListRepository, Session $session): Response
    {
        /* créer un diagramme circulaire */
        $data = [];
        $shoppingLists = $shoppingListRepository->findBy(['user' => $session->get('user')->getId()]);
        if (count($shoppingLists) === 0) {
            return $this->render('stat/stat.html.twig', [
                'controller_name' => 'StatController',
                'message' => 'You have no shopping list',
                'print' => false
            ]);
        } else {
            foreach ($shoppingLists as $tab_list) {
                $ArticlesOfList = $tab_list->getArticles();
                foreach ($ArticlesOfList as $articleInList) {
                    $nameTypeArticle = $articleInList->getArticle()->getType()->getName();
                    if (!(in_array($nameTypeArticle, $data))) {
                        array_push($data, $nameTypeArticle);
                    }
                }
            }
            $associated_tab = array();
            foreach ($data as $type) {
                $associated_tab[$type] = 0;
            }
            foreach ($shoppingListRepository->findBy(['user' => $session->get('user')->getId()]) as $tab_list) {
                $ArticlesOfList = $tab_list->getArticles();
                foreach ($ArticlesOfList as $articleInList) {
                    $nameTypeArticle = $articleInList->getArticle()->getType()->getName();
                    $associated_tab[$nameTypeArticle] += $articleInList->getQuantity();
                }
            }

            $listUserTotalPrice = 0;
            $lowerPrice = 1000000000000000000;
            $higherPrice = -1;
            $nb = 0;
            $average = 0;
            foreach ($shoppingListRepository->findBy(['user' => $session->get('user')->getId()]) as $listUser) {
                $listUserTotalPrice += $listUser->getTotalPrice();
                foreach ($listUser->getArticles() as $listArticle) {
                    $nb += 1;
                    if ($listArticle->getUnityPrice() > $higherPrice) $higherPrice = $listArticle->getUnityPrice();
                    if ($listArticle->getUnityPrice() < $lowerPrice) $lowerPrice = $listArticle->getUnityPrice();
                }
            }
            if ($nb != 0) {
                $average = $listUserTotalPrice / $nb;
                //force le nombre de chiffre après la virgule
                $average = round($average, 2);
            } else {
                $average = 0;
                $lowerPrice = 0;
                $higherPrice = 0;
            }
            $listUserTotalPrice = round($listUserTotalPrice, 2);
            $finalTab = [];
            array_push($finalTab, $lowerPrice);
            array_push($finalTab, $higherPrice);
            array_push($finalTab, $average);

            return $this->render('stat/stat.html.twig', [
                'controller_name' => 'StatController',
                'data' => $associated_tab,
                'stats' => $finalTab,
                'print' => true
            ]);
        }
    }
}
