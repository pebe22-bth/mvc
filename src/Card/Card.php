<?php

namespace App\Card;

/**
 * Card representes a playing card
 */
class Card
{
    protected ?int $value;

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
     * sets the value of the card
     *
     * @param  int $value
     * @return int The value of the card
     */
    public function set(int $value): int
    {
        $this->value = $value;
        return $this->value;
    }

    /**
     * getValue returns the array position of the card (0-51)
     *
     * @return int The value of the card (0-51)
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
    /**
     * getNumber returns the rank of the card (1-13)
     *
     * @return int The rank of the card (1-13)
     */
    public function getRank(): int
    {
        return $this->value % 13 + 1;
    }
}
