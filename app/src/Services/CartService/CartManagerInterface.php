<?php

namespace App\Services\CartService;

use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\Common\Collections\Collection;

interface CartManagerInterface
{
    /**
     * @return Order
     */
    public function getCurrentCart(): Order;

    /**
     * @param Order $order
     * @return void
     */
    public function save(Order $order): void;

    /**
     * @return array|Collection
     */
    public function get() : array|Collection;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool;

    /**
     * @return bool
     */
    public function clear() : bool;

    /**
     * @return float
     */
    public function totalPrice(): float;

    /**
     * @return int
     */
    public function totalItems() : int;
}