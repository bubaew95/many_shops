<?php

namespace App\Controller;

use App\Form\CheckoutType;
use App\Services\Checkout\CheckoutStepsFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart/checkouts/', name: 'app_checkout_')]
class CheckoutController extends AbstractController
{
    private const CATALOG_NAME     = 'checkout';
    private const STEP_METHOD_NAME = 'step_';

    #[Route('/cart/checkoutss/{step_id?2}',
        name: '',
        requirements: ['step_id' => '1|2|3|4|5'])
    ]
    public function index(int $step_id, Request $request): Response
    {
        if($step_id === 1) {
            return $this->redirectToRoute('app_cart');
        }

        $stepParams = $this->{self::STEP_METHOD_NAME . $step_id}($request);

        return $this->render(self::CATALOG_NAME . '/index.html.twig', [
            ...$stepParams,
            'step' => $step_id
        ]);
    }

    #[Route('details', name: 'step')]
    public function step_1(Request $request): Response
    {
        $form = $this->createForm(CheckoutType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
        }

        return $this->render(self::CATALOG_NAME . '/index.html.twig', [
            'step' => 2,
            'form' => $form->createView()
        ]);
    }

    private function step_2($request): mixed
    {
        $form = $this->createForm(CheckoutType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
        }

        return [
            'form' => $form->createView()
        ];
    }

    private function step_3(): array
    {
        return [];
    }

    private function step_4(): array
    {
        return [];
    }

    private function step_5(): array
    {
        return [];
    }
}
