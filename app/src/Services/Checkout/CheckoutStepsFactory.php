<?php

namespace App\Services\Checkout;

use Symfony\Component\HttpFoundation\Request;

class CheckoutStepsFactory
{
    private const STEP_NUMBERS = [
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five'
    ];

    public function createStep(int $step_id, Request $request)
    {
        $step = self::STEP_NUMBERS[$step_id];
        $className = "Step{$step}";
        $classLink = "\\App\\Services\\Checkout\\{$className}";

        if(!class_exists($classLink)) {
            return null;
        }

        /** @var CheckoutStepsInterface $class */
        $class = new $classLink();
        return $class->content($request);
    }

}