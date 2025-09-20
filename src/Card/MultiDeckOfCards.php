<?php

namespace App\Card;

use App\Card\CardGraphic;
use Exception;

/**
 * DeckOfCards - represents a deck of Cards
 */
class MultiDeckOfCards
{
    private array $deck;
    private int $numberOfDecks;

    public function __construct()
    {
        $this->deck = [];
    }
    
    /**
     * buildMultiDeck
     *
     * @param  int $number
     * @return void
     */
    public function buildMultiDeck(int $number): void
    {
        for ($j = 0; $j < $number; $j++) {
            for ($i = 0; $i < 52; $i++) {
                $this->deck[] = new CardGraphic();
                $this->deck[$i + ($j * 52)]->set($i);
                $this->numberOfDecks = $number;
            }
        }
    }
        
    /**
     * shuffle
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
    public function getNumberOfDecks() {
        return $this->numberOfDecks;
    }
}