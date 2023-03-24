<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class FileExistsExtensionRuntime implements RuntimeExtensionInterface
{
    public function is_file($value): bool
    {
        return is_file("../templates/{$value}");
    }
}
