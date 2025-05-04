<?php

namespace App\Card;



/**
 * Card representes a playing card in a standard deck of cards
 */
class Card
{
    protected $value;
    
    /**
     * __construct sets the value of the card to null
     *
     * @return void
     */
    public function __construct()
    {
        $this->value = null;
    }
    
    /**
     * set sets the value of the card
     *
     * @param  mixed $value
     * @return int The value of the card that was just set
     */
    public function set($value): int
    {
        $this->value = $value;
        return $this->value;
    }
    
    /**
     * getValue returns the value of the card
     *
     * @return int The value of the card
     */
    public function getValue(): ?int
    {
        return $this->value;
    }
    
    /**
     * getAsString returns the value of the card as a string
     *
     * @return string The value of the card as a string
     */
    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
