<?php

namespace App\Services\CartService;

use App\Entity\Order;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class CartManager implements CartManagerInterface
{
    /**
     * CartManager constructor.
     *
     * @param CartSessionStorage $cartSessionStorage
     * @param OrderFactory $cartFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private CartSessionStorage $cartSessionStorage,
        private OrderFactory $cartFactory,
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * Gets the current cart.
     *
     * @return Order
     */
    public function getCurrentCart(): Order
    {
        $cart = $this->cartSessionStorage->getCart();

        if (!$cart) {
            $cart = $this->cartFactory->create();
        }

        return $cart;
    }

    /**
     * Persists the cart in database and session.
     *
     * @param Order $order
     */
    public function save(Order $order): void
    {
        // Persist in database
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        // Persist in session
        $this->cartSessionStorage->setCart($order);
    }

    public function get(): array|Collection
    {
        $order = $this->cartSessionStorage->getCart();
        if(!$order) {
            return [];
        }
        return $order->getItems();
    }

    public function delete(int $id): bool
    {
        // TODO: Implement delete() method.
    }

    public function clear(): bool
    {
        // TODO: Implement clear() method.
    }

    public function totalPrice(): float
    {
        // TODO: Implement totalPrice() method.
    }

    public function totalItems(): int
    {
        $order = $this->cartSessionStorage->getCart();
        return $order ? $order->getItemsTotal() : 0;
    }
}