<?php

namespace App\Services\eav;

class SelectType extends BaseType
{
    public function __construct(
        private readonly array $option
    ) {}

    public function field(): string
    {
        $eav  = "<select name='fields[{$this->option['name']}]'  class='form-select form-select-sm'>";
        $eav .= $this->each($this->option, function ($item) {
            return "<option value='{$item['value']}'>{$item['value']}</option>";
        });
        $eav .= "</select>";

        return $eav;
    }
}