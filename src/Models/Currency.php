<?php

namespace Sitec\Commerce\Models;

class Currency
{
    public $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function toHtml()
    {
        return number_format($this->value * 0.01, 2, '.', '');
    }

    public function integer()
    {
        return (int) $this->value;
    }

    public function add($money)
    {
        $this->value += $money;

        return $this;
    }
}
