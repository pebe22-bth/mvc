<?php

namespace App\Card;

class Card
{
    protected $value;

    public function __construct()
    {
        $this->value = null;
    }

    public function set($value): int
    {
        $this->value = $value;
        return $this->value;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
