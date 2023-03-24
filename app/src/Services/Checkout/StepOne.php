<?php

namespace App\Services\Checkout;

use App\Form\CheckoutType;
use Symfony\Component\HttpFoundation\Request;

class StepOne implements CheckoutStepsInterface
{
    public function content(Request $request) : array
    {
        return [];
    }
}