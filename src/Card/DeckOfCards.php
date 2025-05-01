<?php

namespace App\Card;

use App\Card\CardGraphic;

class DeckOfCards
{
    private $deck = [];

    public function __construct()
    {
        $this->deck = [];
        $this->buildDeck();
    }
    private function buildDeck()
    {
        for ($i = 0; $i < 52; $i++) {
            $this->deck[] = new CardGraphic();
            $this->deck[$i]->set($i);
        }
    }
    public function shuffle()
    {
        shuffle($this->deck);
    }

    public function drawCard(): CardGraphic
    {
        $card = array_pop($this->deck);
        return $card;
    }


    public function getNumberOfCards(): int
    {
        return count($this->deck);
    }

    public function getDeckAsValues(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

    public function getDeck(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}
