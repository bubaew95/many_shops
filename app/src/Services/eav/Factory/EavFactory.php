<?php

namespace App\Services\eav\Factory;

class EavFactory
{
    public function createHtmlField(string $type, mixed $data)
    {
        $className = ucfirst($type) . "Type";
        $classLink = "\\App\\Services\\eav\\{$className}";
        if(!class_exists($classLink)) {
            return null;
        }

        $class = new $classLink($data);
        return $class->field();
    }
}