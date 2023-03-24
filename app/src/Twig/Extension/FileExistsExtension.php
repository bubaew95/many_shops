<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\FileExistsExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FileExistsExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_file', [FileExistsExtensionRuntime::class, 'is_file']),
        ];
    }
}
