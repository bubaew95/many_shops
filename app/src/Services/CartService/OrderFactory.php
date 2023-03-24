<?php

namespace App\Services\CartService;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Products;

class OrderFactory
{
    /**
     * Creates an order.
     *
     * @return Order
     */
    public function create(): Order
    {
        return new Order(Order::STATUS_CART);
    }

    /**
     * Creates an item for a product.
     *
     * @param Products $product
     * @param int $quantity
     * @param string $price
     * @return OrderItem
     */
    public function createItem(Products $product, int $quantity, string $price): OrderItem
    {
        return new OrderItem($product, $quantity, $product->getPrice());
    }
}