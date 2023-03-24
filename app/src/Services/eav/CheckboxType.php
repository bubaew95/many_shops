<?php

namespace App\Services\eav;

class CheckboxType extends BaseType
{
    public function __construct(
        private readonly array $option
    ) {}

    public function field(): string
    {
        return $this->each($this->option, function ($item, $key) {
            $eav  = '<div class="d-flex align-items-center gap-2">';
            $eav .= "<input type='checkbox' id='id-{$this->option['id']}{$key}' value='{$item['value']}' name='fields[{$this->option['name']}][{$item['id']}]'  />";
            $eav .= "<label for='id-{$this->option['id']}{$key}'>{$item['value']}</label>";
            $eav .= "</div>";
            return $eav;
        });
    }
}