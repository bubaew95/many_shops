<?php

namespace App\Services\eav;

class RadioType extends BaseType
{

    public function __construct(
        private readonly array $option
    ){}

    public function field(): string
    {
        return $this->each($this->option, function ($item, $key) {
            $eav  = '<div class="d-flex align-items-center gap-2">';
            $eav .= "<input type='radio' id='id-{$this->option['id']}{$key}' value='{$item['value']}' name='fields[{$this->option['name']}][{$this->option['id']}]' />";
            $eav .= "<label for='id-{$this->option['id']}{$key}'>{$item['value']}</label>";
            $eav .= "</div>";

            return $eav;
        });
    }
}