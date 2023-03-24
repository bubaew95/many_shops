<?php

namespace App\Controller;

use App\Entity\AttributeType;
use App\Entity\Product;
use App\Repository\AttributeTypeRepository;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CatalogController extends BaseController
{
    #[Route('/catalog/{category?}', name: 'app_catalog',requirements: ['category' => '.*'])]
    public function index(
        Request $request,
        ProductsRepository $productsRepository,
        ?string $category
    ): Response {
        if(!is_null($category)) {
            $categoryExplode = explode('/', $category);
            $category = end($categoryExplode);
        }

        $paginator = $this->paginator(
            $request,
            $productsRepository->findByLimit($category)
        );

        return $this->render('catalog/index/index.html.twig', [
            'products' => $paginator,
        ]);
    }

    #[Route('/details/{alias}', name: 'app_detail')]
    public function details(Product $product, AttributeTypeRepository $attributeType): Response
    {
        $attributes = $attributeType->findAll();
        return $this->render('catalog/details/index.html.twig', [
            'product' => $product,
            'attributes' => $attributes
        ]);
    }
}
