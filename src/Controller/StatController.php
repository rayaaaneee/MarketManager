<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ShoppingListRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/stat')]
class StatController extends AbstractController
{
    #[Route('/', name: 'stat')]
    public function index(ShoppingListRepository $shoppingListRepository, Session $session,UserRepository $userRepository): Response
    {
        $user = $userRepository->find($session->get('user')->getId());
        $shoppingLists = $user->getAllShoppingLists();


        // if $shopingList is in $shoppingLists
        if (!in_array($shoppingList, $shoppingLists)) {
            $printMessage = true;
            $isSuccess = false;
            $message = "You don't have access to view this list.";
            $shopping_lists = $shoppingListRepository->findBy(['user' => $session->get('id')]);
            $new_lists = [];
            $totalPriceList = 0;
            $nbItems = 0;
            foreach ($shopping_lists as $shopping_list) {
                if (!$shopping_list->hasEndDate()) {
                    array_push($new_lists, $shopping_list);
                    $totalPriceList += $shopping_list->getTotalPrice();
                    $nbItems += $shopping_list->getNbArticles();
                } else {
                    $endDate = DateTime::createFromInterface($shopping_list->getEndDate())->setTime(0, 0, 0);
                    $now = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                    $now = $now->setTime(0, 0, 0);
                    if ($endDate >= $now) {
                        array_push($new_lists, $shopping_list);
                        $totalPriceList += $shopping_list->getTotalPrice();
                        $nbItems += $shopping_list->getNbArticles();
                    }
                }
            }
            return $this->render('list/list.html.twig', [
                // recupere que les listes de l'utilisateur connecté
                'shopping_lists' => $new_lists,
                'canEdit' => true,
                'printMessage' => $printMessage,
                'isSuccess' => $isSuccess,
                'message' => $message,
                'totalPriceList' => $totalPriceList,
                'nbItems' => $nbItems
            ]);
        }
        $data = [];
        $user = $userRepository->find($session->get('user')->getId());
        $shoppingLists = $user->getAllShoppingLists();
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
            foreach ($shoppingLists as $tab_list) {
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
            foreach ($shoppingLists as $listUser) {
                $listUserTotalPrice += $listUser->getTotalPrice();
                $nb += 1;
                foreach ($listUser->getArticles() as $listArticle) {
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
