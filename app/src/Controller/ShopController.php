<?php

namespace App\Controller;

use App\Entity\Shops;
use App\Repository\ProductsRepository;
use App\Repository\ShopsRepository;
use App\Repository\WidgetRepository;
use App\Services\WidgetService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends BaseController
{
    #[Route('/shops', name: 'app_shop', priority: 1)]
    public function index(
        ShopsRepository $shopsRepository
    ): Response {
        $shops = $shopsRepository->findAll();

        return $this->render('shop/index/index.html.twig', [
            'shops' => $shops,
        ]);
    }

    #[Route('/{alias}', name: 'app_shop_details')]
    public function details(
        string             $alias,
        Shops              $shop,
        ProductsRepository $productsRepository,
        WidgetService      $widgetService
    ): Response {
        $products = $productsRepository->findProductsByShopResult($alias);

        return $this->render('shop/details/index/index.html.twig', [
            'shop'     => $shop,
            'products' => $products,
            'widgets'  => $widgetService->widgets($shop)
        ]);
    }

//    #[Route('/{}')]
    public function category(string $alias)
    {

    }

    /**
     * Каталог товаров
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/{alias}/catalog', name: 'app_shop_search')]
    public function search(
        string             $alias,
        Request            $request,
        ProductsRepository $productsRepository
    ): Response {
        $products = $this->paginator(
            $request,
            $productsRepository->findProductsByShop($alias)
        );

        return $this->render('catalog/index/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * Страницы магазина
     *
     * @param ShopsRepository $shopsRepository
     *
     * @return Response
     */
    #[Route('/{alias}/page/{page}', name: 'app_shop_pages')]
    public function page(
        ShopsRepository $shopsRepository
    ): Response {
        $shops = $shopsRepository->findAll();

        return $this->render('shop/details/index.html.twig', [
            'shops' => $shops,
        ]);
    }
}
