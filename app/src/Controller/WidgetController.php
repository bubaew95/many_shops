<?php

namespace App\Controller;

use App\Interfaces\WidgetInterface;
use App\Repository\WidgetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WidgetController extends AbstractController
{
    private array $widgets;
    public function __construct(
        private WidgetRepository $repository
    ) {
        $widgets = $this->repository->findAll();
        foreach ($widgets as $item) {
            $this->widgets[$item->getBlock()][] = $item;
        }
    }

    #[Route('/widget/{block}', name: 'app_widget')]
    public function index(int $block): Response
    {
        return $this->render('widget/index.html.twig', [
            'items' => $this->widgets[$block] ?? null,
            'template' => WidgetInterface::WIDGETS[$block]
        ]);
    }

}
