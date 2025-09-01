<?php

namespace App\Card;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use Exception;

/**
 * Game21 represents the 21 card game with a dealer that always draws to 17.
 */
class Game21
{
    private CardHand $bankHand;
    private DeckOfCards $deck;
    private CardHand $playerHand;
    private ?string $winner;
    private string $turn;

    /**
     * __construct sets the value of the card to null
     *
     * @return void
     */
    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->deck->shuffle();
        $this->bankHand = new CardHand();
        $this->playerHand = new CardHand();
        $this->winner = null;
        $this->turn = "player";
    }

    /**
     * isBust - checks if player is bust (value over 21)
     *
     * @param  int $value
     * @return bool
     */
    private function isBust(int $value): bool
    {
        return $value > 21;
    }
    /**
     * is17 - checks if player has 17 or over
     *
     * @param  int $value
     * @return bool
     */
    private function is17(int $value): bool
    {
        return $value > 16;
    }

    /**
     * getHandValue - returns the best value of the hand
     *
     * @param  CardHand $hand
     * @return int
     */
    public function getHandValue(
        CardHand $hand
    ): int {
        $handValue = 0;
        $aceCount = 0;


        foreach ($hand->getHand() as $card) {
            $value = $card->getRank();
            if ($value == 1) {
                $aceCount++;
            }
            $handValue += $value;
        }
        // Can aces by 14 without busting

        for ($i = 0; $i < $aceCount; $i++) {
            if ($handValue < 9) {
                $handValue += 13;
            }
        }
        return $handValue;
    }
    public function playerDraw(): int
    {
        $handValue = 0;

        if ($this->turn !== "player") {
            throw new Exception("Player has stopped or game not started");
        }
        $this->playerHand->add($this->deck->drawCard());
        $handValue = $this->getHandValue($this->playerHand);
        if ($this->isBust($handValue)) {
            $this->winner = "bank";
        }
        return $handValue;

    }
    public function bankDraw(): int
    {
        if ($this->turn !== "bank") {
            throw new Exception("Player has not stopped");
        }
        $this->bankHand->add($this->deck->drawCard());
        $handValue = $this->getHandValue($this->bankHand);
        if ($this->isBust($handValue)) {
            $this->winner = "player";
            return $handValue;
        }
        if (!$this->is17($handValue)) { // Bank has not drawn to 17
            return $handValue;
        }
        if ($handValue >= $this->getHandValue($this->playerHand)) {
            $this->winner = "bank";
            return $handValue;
        }
        $this->winner = "player";
        return $handValue;

    }
    /**
     * stop - Player stops drawing cards, banks turn
     *
     * @return void
     */
    public function playerStop()
    {
        $this->turn = "bank";
    }
    /**
     * getPlayerHand - return the player's hand
     *
     * @return CardHand
     *
     */
    public function getPlayerHand(): CardHand
    {
        return $this->playerHand;
    }
    /**
     * getBankHand - returs banks hand
     *
     * @return CardHand
     */
    public function getBankHand(): CardHand
    {
        return $this->bankHand;
    }
    /**
     * getTurn - return who's next turn: player or bank
     *
     * @return string
     */

    public function getTurn(): string
    {
        return $this->turn;
    }
    /**
     * getWinner - returns the winner. If null, the game is active
     *
     * @return string|null
     */
    public function getWinner(): ?string
    {
        return $this->winner;
    }
}
