<?php

namespace App\Services\CartService;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartSessionStorage
{
    /**
     * @var string
     */
    public const CART_KEY_NAME = 'cart_id';

    public function __construct(
        private RequestStack $requestStack,
        private OrderRepository $cartRepository
    ) {}

    /**
     * Gets the cart in session.
     *
     * @return Order|null
     */
    public function getCart(): ?Order
    {
        return $this->cartRepository->findByCartId($this->getCartId());
//            ->findOneBy([
//            'id'        => $this->getCartId(),
//            'status'    => Order::STATUS_CART
//        ]);
    }

    /**
     * Sets the cart in session.
     *
     * @param Order $cart
     */
    public function setCart(Order $cart): void
    {
        $this->requestStack->getSession()->set(self::CART_KEY_NAME, $cart->getId());
    }

    /**
     * Returns the cart id.
     *
     * @return int|null
     */
    private function getCartId(): ?int
    {
        return $this->requestStack->getSession()->get(self::CART_KEY_NAME);
    }
}