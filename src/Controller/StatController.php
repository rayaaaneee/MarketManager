<?php

namespace App\Controller;

use App\Repository\ShoppingListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[Route('/stat')]
class StatController extends AbstractController
{
    #[Route('/', name: 'stat')]
    public function index(ChartBuilderInterface $chartBuilder, ShoppingListRepository $shoppingListRepository, Session $session): Response
    {
        /* créer un diagramme circulaire */
        $data = [];
        $chart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
        foreach ($shoppingListRepository->findBy(['user' => $session->get('id')]) as $tab_list){
            $ArticlesOfList = $tab_list->getArticles();
            foreach ($ArticlesOfList as $articleInList){
                $nameTypeArticle = $articleInList->getArticle()->getType()->getName();
                if(!(in_array($nameTypeArticle,$data))){
                    array_push($data,$nameTypeArticle);
                }
            }
        }
        $associated_tab = array();
        foreach ($data as $type){
            $associated_tab[$type] = 0;
        }
        foreach ($shoppingListRepository->findBy(['user' => $session->get('id')]) as $tab_list){
            $ArticlesOfList = $tab_list->getArticles();
            foreach ($ArticlesOfList as $articleInList){
                $nameTypeArticle = $articleInList->getArticle()->getType()->getName();
                $associated_tab[$nameTypeArticle] += $articleInList->getQuantity();
            }
        }
        $chart->setData([
            'labels' => [array_keys($associated_tab)],
            'datasets' => [
                [
                    'label' => 'Type of articles in your lists',
                    'data' => array_values($associated_tab),
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)',
                    ],
                ],
            ],
        ]);

        $chart->setOptions([
            'responsive' => true,
            'maintainAspectRatio' => false,
        ]);

        return $this->render('stat/stat.html.twig', [
            'controller_name' => 'StatController',
            'chartType' => $chart,
        ]);
    }
}
