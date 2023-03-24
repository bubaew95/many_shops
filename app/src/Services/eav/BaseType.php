<?php

namespace App\Services\eav;

abstract class BaseType implements EavInterface
{
    abstract public function field() : string;

    public function each(array $data, callable $f): string
    {
        $items = '';
        foreach ($data['attributeValues'] as $key => $item) {
            $items .= $f($item, $key);
        }

        return $items;
    }
}