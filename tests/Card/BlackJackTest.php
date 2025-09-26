<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class BlackJack.
 */
class BlackJackTest extends TestCase
{
    public function testCreateBlackJack(): void
    {
        $game = new BlackJack();
        $game->startGame(1, 1);
        $res = $game->getTurn();
        $exp = "player";
        $this->assertEquals($exp, $res);

    }

    public function testDraw(): void
    {
        $game = new BlackJack();
        $game->startGame(1, 1);
        $res = $game->getPlayerValue();
        $this->assertTrue(( $res[0] >= 2 ) && ( $res[0] <= 21) );

        $game->playerStop();
        $res = $game->getTurn();
        $exp = "bank";
        $this->assertEquals($exp, $res);

        $game->bankDraw();
        $hand = $game->getBankHand();
        $res = $game->getHandValue($hand);
        $this->assertTrue(($res >= 2) && ($res <= 21));

    }
    public function testgetNumberOfDecks(): void
    {
        $game = new BlackJack();
        $game->startGame(1, 1);
        $res = $game->getNumberOfDecks();
        
        $this->assertEquals(1, $res);
    }
    public function testgetNumberOfhands(): void
    {
        $game = new BlackJack();
        $game->startGame(1, 1);
        $res = $game->getNumberOfHands();
        
        $this->assertEquals(1, $res);
    }
    public function testgetBankDraw(): void
    {
        $game = new BlackJack();
        $game->startGame(1, 1);
        $game->playerStop();
        while ( $game->getTurn() === "player" ){
            $player = $game->playerDraw();
            }
        while ( $game->getTurn() === "bank"){
            $game->bankDraw();
        }
        $res = $game->getWinner();

        $this->assertMatchesRegularExpression("/^(player|bank)$/", $res[0]);
    }
    public function testPlayerBust(): void
    {
        $game = new BlackJack();
        $game->startGame(1, 1);
        while ( $game->getWinner() !== ["bank"] ){
            $player = $game->playerDraw();
            }
        
        $res = $game->getProfit();
        $this->assertEquals( -1, $res);
    }
    public function testBankBust(): void
    {
        $winner = [];
        $bankValue = 0;
        while ( ( $winner !== ["player"] ) && ( $bankValue < 22 ) ){
            $game = new BlackJack();
            $game->startGame(1, 1);
            $game->playerStop();
            while ( $game->getTurn() !== "gameover" )
                {
                $game->bankDraw();
                }
            $winner = $game->getWinner();
            $bank = $game->getBankHand();
            $bankValue = $game->getHandValue($bank);
        }
        $res = $game->getProfit();
        $this->assertEquals( 1, $res);
    }
    public function testBankWins(): void
    {
        $winner = [];
        while ( $winner !== ["bank"] ){
            $game = new BlackJack();
            $game->startGame(1, 1);
            $game->playerStop();
            while ( $game->getTurn() !== "gameover" )
                {
                $game->bankDraw();
                }
            $winner = $game->getWinner();
        }
        $res = $game->getProfit();
        $this->assertEquals( -1, $res);
    }
    public function testSetPlayer(): void
    {
        $game = new BlackJack();
        $game->setPlayer("1");
        
        $res = $game->getPlayer();
        $this->assertEquals( 1, $res);
    }
    public function testGetDeck(): void
    {
        $game = new BlackJack();
        $game->startGame(2,1);
        $res = $game->playerDraw();
        $exp = 1;
        $this->assertEquals($exp, count($res));

        $res = $game->getDeck();
        $exp = 100;
        $this->assertEquals($exp, count($res));
    }
    public function testGetPlayerAndBankHand(): void
    {
        $game = new BlackJack();
        $game->startGame(1,1);
        $hand = $game->getPlayerHand(0);

        $res = $game->getHandValue($hand);
        $this->assertTrue($res >= 2 && $res <= 21);

        $hand = $game->getBankHand();
        $res = $game->getHandValue($hand);
        $this->assertTrue($res >= 2 && $res <= 11);

    }
    public function testGetPlayerHandAsString(): void
    {
        $game = new BlackJack();
        $game->startGame(1,1);
        $hand = $game->getPlayerHandsAsString();
        $exp = 2;
        $this->assertEquals($exp, count($hand[0]));


    }
    public function testGetCurrentHand(): void
    {
        $game = new BlackJack();
        $game->startGame(1,1);
        $res = $game->getCurrentHand();
        $exp = 0;
        $this->assertEquals($exp, $res);


    }
    public function testBankDrawTooEarly(): void
    {
        $game = new BlackJack();
        $game->startGame(1,1);
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Player has not stopped");
        $res = $game->bankDraw();

    }
    public function testPlayerDrawTooLate(): void
    {
        $game = new BlackJack();
        $game->startGame(1,1);
        $game->playerStop();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Player has stopped or game not started");
        $res = $game->playerDraw();
    }
    
   

}
