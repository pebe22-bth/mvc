<?php

namespace App\Card;

use App\Card\CardGraphic;
use Exception;

/**
 * DeckOfCards - represents a deck of Cards
 */
class DeckOfCards
{
    /**
     * deck
     *
     * @var array<CardGraphic> $deck
     */
    private array $deck = [];

    public function __construct()
    {
        $this->deck = [];
        $this->buildDeck();
    }
    /**
     * buildDeck - fills the deck with 52 cards
     *
     * @return void
     */
    private function buildDeck(): void
    {
        for ($i = 0; $i < 52; $i++) {
            $this->deck[] = new CardGraphic();
            $this->deck[$i]->set($i);
        }
    }
    /**
     * shuffle - shuffles the deck of cards
     *
     * @return void
     */
    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    /**
     * drawCard -
     *
     * @return CardGraphic
     */
    public function drawCard(): CardGraphic
    {
        if (count($this->deck) === 0) {
            throw new Exception("Error: Deck of cards is empty");
        }
        $card = array_pop($this->deck);
        return $card;
    }


    /**
     * getNumberOfCards - returns the number of remaining cards in the deck
     *
     * @return int
     */
    public function getNumberOfCards(): int
    {
        return count($this->deck);
    }

    /**
     * getDeckAsValues - returns the values of the cards in the deck
     * @return array<int|null> $values
     */
    public function getDeckAsValues(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

    /**
     * getDeck - returns the string representation of the cards in the deck
     * @return array<string|null> $values
     */
    public function getDeck(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}
