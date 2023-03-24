<?php

namespace App\Services\Checkout;

use Symfony\Component\HttpFoundation\Request;

class StepTwo implements CheckoutStepsInterface
{
    public function content(Request $request) : array
    {
        return  [];
    }
}