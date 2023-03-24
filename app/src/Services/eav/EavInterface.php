<?php

namespace App\Services\eav;

interface EavInterface
{
    public function each(array $data, callable $f): string;
}