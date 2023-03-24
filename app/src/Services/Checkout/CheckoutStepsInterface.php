<?php

namespace App\Services\Checkout;

use Symfony\Component\HttpFoundation\Request;

interface CheckoutStepsInterface
{
    public function content(Request $request) : array;
}