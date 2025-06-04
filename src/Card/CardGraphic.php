<?php

namespace App\Card;

/**
 * CardGraphic represents a playing card represented as a string conaining color and value (2 characters)
 */
class CardGraphic extends Card
{
    /**
     * colors
     *
     * @var array<string> $colors
     */
    private array $colors = ['♠', '♥', '♦', '♣'];
    /**
     * values
     *
     * @var array<string> $values
     */
    private array $values = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
    /**
     * representation
     *
     * @var array<?string> The representation of the card based on color and value
     */
    private array $representation = [];

    public function __construct()
    {
        parent::__construct();
        $this->buildArrayOfCards();
    }

    /**
     * buildArrayOfCards - fills the representation array with all cards
     *
     * @return void Builds the array of card representation based on color and value
     */
    private function buildArrayOfCards()
    {
        foreach ($this->colors as $color) {
            foreach ($this->values as $value) {
                $this->representation[] = $value . $color;
            }
        }
    }

    /**
     * getAsString - return the value of the card as a graphical string
     *
     * @return string The value of the card as a graphical string
     */
    public function getAsString(): string
    {
        if (!isset($this->representation[$this->value])) {
            return "[{$this->value}]";
        }
        return $this->representation[$this->value];

    }
}
