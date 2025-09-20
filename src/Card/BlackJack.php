<?php

namespace App\Card;

use App\Card\MultiDeckOfCards;
use App\Card\CardHand;
use Exception;

/**
 * BlackJack represents the classic Black Jack card game 
 * Player can play up to 3 hands
 */
class BlackJack
{
    private CardHand $bankHand;
    private MultiDeckOfCards $deck;
    private array $playerHand;
    private array $winner;
    private string $turn;
    private int $currenthand;
    private int $playerId;

    /**
     * __construct sets the value of the card to null
     *
     * @return void
     */
    public function __construct()
    {
        $this->deck = new MultiDeckOfCards();        
        $this->winner = [];
        $this->turn = "player";
        $this->currenthand = 0;
        $this->profit = [];
    }    
    /**
     * initialDraw, two cards per hand + bank 1 card
     *
     * @return void
     */
    private function initialDraw(): void
    {
        foreach ($this->playerHand as $hand){
            $hand->add($this->deck->drawCard());
            $hand->add($this->deck->drawCard());
        }
        $this->bankHand->add($this->deck->drawCard());
    }
    public function startGame(int $numberOfDecks, int $numberOfHands){
        $this->deck->buildMultiDeck($numberOfDecks);
        $this->deck->shuffle();
        $this->bankHand = new CardHand();
        $this->playerHand = [];
            for ($i = 0; $i < $numberOfHands; $i++) {
                $this->playerHand[$i] = new CardHand();
            }
         $this->initialDraw();
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
     * getHandValue
     *
     * @return void
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
                if (in_array($value, [10,11,12,13])) {
                    $handValue += 10;
                }
                else {
                $handValue += $value;
                }
        }
        // Add aces to hand value. 
        // Check if aces can be 11 without busting

        for ($i = 0; $i < $aceCount; $i++) {
            if ($handValue < 12) {
                $handValue += 10;
            }
        }
        return $handValue;
    }
        
    /**
     * getPlayerValue
     *
     * @return array
     */
    public function getPlayerValue(): array 
    {
        $allHandValue = [];
        foreach ($this->playerHand as $hand) {
            $allHandValue[] = $this->gethandValue($hand);
        }
        return $allHandValue;
    }        
    /**
     * playerDraw
     *
     * @return array
     */
    public function playerDraw(): array
    {
        if ($this->turn !== "player") {
            throw new Exception("Player has stopped or game not started");
        }
        $this->playerHand[$this->currenthand]->add($this->deck->drawCard());
        $values = $this->getPlayerValue();
        if ($this->isBust($values[$this->currenthand])) {
            $this->winner[$this->currenthand] = "bank";
            $this->currenthand++;
            if ( $this->currenthand >= $this->getNumberOfHands()){
                $this->turn = "bank";
            }
        }
        return $this->getPlayerValue();

    }
    
    /**
     * bankDraw
     *
     * @return void
     */
    public function bankDraw(): void
    {
        if ($this->turn !== "bank") {
            throw new Exception("Player has not stopped");
        }
        $this->bankHand->add($this->deck->drawCard());
        $bankValue = $this->getHandValue($this->bankHand);
        if ($this->isBust($bankValue)){
            $bankValue = 0;
            $this->turn = "gameover";
            $this->calcWinner($bankValue);
        }
        elseif ($this->is17($bankValue)){
            $this->turn = "gameover";
            $this->calcWinner($bankValue);
        }
    }        
    /**
     * calcWinner
     * Note that any already busted player hands is already set as won by the bank.
     * Busted bank means bankValue is 0
     * @return int
     */
    private function calcWinner(int $bankValue): void
    {
        
        if ($this->turn !== "gameover") {
            throw new Exception("Game not finished. Cannot calculate results");
        }
        $profit = 0;
        foreach ($this->getPlayerValue() as $i => $playerValue) {
            if (!isset($this->winner[$i])){
                if ($playerValue > $bankValue ){
                    $this->winner[$i] = "player";
                }
                elseif ($playerValue === $bankValue ){
                    $this->winner[$i] = "draw";
                }
                else{
                    $this->winner[$i] = "bank";
                }
            }
        }
    }
    /**
     * stop - Player stops drawing cards, banks turn
     *
     * @return void
     */
    public function playerStop()
    {
        $this->currenthand++;
        if ( $this->currenthand == $this->getNumberOfHands() ){
            $this->turn = "bank";
        }
    }
    /**
     * getPlayerHand - return the player's hand
     *
     * @return CardHand
     *
     */
    public function getPlayerHand(int $number): CardHand
    {
        return $this->playerHand[$number];
    }
    public function getPlayerHandsAsString(): array
    {
        $data = [];
        for ($i = 0; $i < $this->getNumberOfHands(); $i++) {
                $data[] = $this->playerHand[$i]->getString();
            }

        return $data;
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
    public function getCurrentHand(): int
    {
        return $this->currenthand;
    }   
    public function getNumberOfHands(): int
    {
        return count($this->playerHand); 
    }  
    /**
     * getWinner - returns the winner.
     *
     * @return array
     */
    public function getWinner(): array
    {
        return $this->winner;
    }    
    /**
     * getDeck
     *
     * @return array
     */
    public function getDeck(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }    
    /**
     * getPlayer
     *
     * @return int
     */
    public function getPlayer(): int
    {
        return $this->playerId;
    }    
    /**
     * setPlayer
     *
     * @param  mixed $playerId
     * @return void
     */
    public function setPlayer(int $playerId): void
    {
        $this->playerId = $playerId;
    }
    public function getProfit(): int
    {
        $profit = array_count_values($this->winner);
        return ($profit["player"] ?? 0) - ($profit["bank"] ?? 0);
    }
    public function getNumberOfDecks(): int
    {
        return $this->deck->getNumberOfDecks();
    }
}
