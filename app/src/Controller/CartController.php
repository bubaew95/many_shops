<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Services\CartService\CartManager;
use App\Services\CartService\CartManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="app_cart")
     * @param CartManagerInterface $cartManager
     * @return Response
     */
    public function index(CartManagerInterface $cartManager): Response
    {
        $cart           = $cartManager->get();
        $cartTemplate   = $cart ? 'index.html.twig' : 'cart-empty.html.twig';

        return $this->render("cart/{$cartTemplate}", [
            'cart' => $cart,
        ]);
    }

    /**
     * @param Request $request
     * @param CartManager $cartManager
     * @param Product $product
     * @return JsonResponse|Response
     */
    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function addToCart(
        Request $request,
        CartManager $cartManager,
        Product $product
    ) : JsonResponse|Response
    {
        $quantity  = $request->request->get('quantity') ?? 1;

        $order = $cartManager
            ->getCurrentCart()
            ->addItem(
                new OrderItem($product, $quantity, $product->getPrice())
            )
            ->setItemsTotal(1)
        ;

        if($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $order->setUser($this->getUser());
        }

        $cartManager->save($order);
        if($request->isXmlHttpRequest()) {
            return $this->render('cart/modal.html.twig', compact('product', 'quantity'));
        }

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/cart/delete-item/{id}', name: 'app_cart_delete_item')]
    public function deleteItem(int $id)
    {
        dd($id);
    }

    /**
     * @Route("/cart/clear", name="app_cart_clear")
     * @return RedirectResponse
     */
    public function clear(): RedirectResponse
    {
        return $this->redirectToRoute('app_index');
    }
}
