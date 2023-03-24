<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use App\Repository\ProductsRepository;
use App\Services\WidgetService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends BaseController
{
    #[Route('/', name: 'app_index')]
    public function index(
        ProductsRepository $productsRepository,
        NewsRepository     $blogRepository,
        WidgetService      $widgetService,
        LoggerInterface $logger
    ): Response {
        $products = $productsRepository->findAll();
        $blogs    = $blogRepository->findAll();
        $slider = $widgetService->slider(6);

        $logger->info('slider', $slider);
        return $this->render('index/index.html.twig', [
            'products' => $products,
            'news'     => $blogs,
            'slider'   => $slider
        ]);
    }
}