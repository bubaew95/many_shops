<?php

namespace App\Twig;

use App\Services\eav\Factory\EavFactory;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EavModelExtension extends AbstractExtension
{
    public function __construct(
        private readonly EavFactory $eavFactory
    ) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('eav_model', [$this, 'eav'], ['is_safe' => ['html']]),
        ];
    }

    public function eav($options): string
    {
        $eav = '';

        foreach ($options as $option) {
            $eav .= '<div class="col">';
            $eav .= "<label class='form-label'>{$option['name']}</label>";
            $eav .= $this->eavFactory->createHtmlField($option['type'], $option);
            $eav .= "</div>";
        }

        return $eav;
    }
}
