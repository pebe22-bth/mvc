<?php

namespace App\Card;

use App\Card\CardGraphic;

/**
 * CardHand - holds the card drawn from the deck by a player
 */
class CardHand
{
    /**
     * hand - comntains the cards in a hand
     *
     * @var array<CardGraphic> $hand
     */
    private array $hand = [];

    /**
     * add - adds a card to the hand
     *
     * @param  CardGraphic $card
     */
    public function add(CardGraphic $card): void
    {
        $this->hand[] = $card;
    }

    /**
     * getNumberCards - returns the number of cards in the hand
     *
     * @return int
     */
    public function getNumberCards(): int
    {
        return count($this->hand);
    }

    /**
     * getValues - returns the values of the cards in the hand
     * @return array<int|null>
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

    /**
     * getString - returns the string representation of the cards in the hand
     *
     * @return array<string|null>
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
    /**
     * getHand
     *
     * @return array<CardGraphic>
     */
    public function getHand(): array
    {
        return $this->hand;
    }
}
