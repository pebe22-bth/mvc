<?php

namespace App\Card;

class CardGraphic extends Card
{
    private $colors = ['♠', '♥', '♦', '♣'];
    private $values = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
    private $representation = [];

    public function __construct()
    {
        parent::__construct();
        $this->buildArrayOfCards();
    }

    private function buildArrayOfCards()
    {
        foreach ($this->colors as $color) {
            foreach ($this->values as $value) {
                $this->representation[] = $value . $color;
            }
        }
    }

    public function getAsString(): string
    {
        return $this->representation[$this->value];
    }
}
