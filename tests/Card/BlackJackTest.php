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
        $res = $game->playerDraw();
        $this->assertTrue($res[0] >= 1 && $res[0] <= 36);

        $game->playerStop();
        $res = $game->getTurn();
        $exp = "bank";
        $this->assertEquals($exp, $res);

        $game->bankDraw();
        $hand = $game->getBankHand();
        $res = $game->getHandValue($hand);
        $this->assertTrue(($res >= 2) && ($res <= 21));



    }
    public function testgetPlayerValue(): void
    {
        $game = new BlackJack();
        $game->startGame(1, 1);
        $play = $game->playerDraw();
        $values = $game->getPlayerValue();
        $res = $values[0];
        $this->assertTrue($res > 1 && $res < 22);


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
    public function testSetPlayer(): void
    {
        $game = new BlackJack();
        $game->setPlayer("1");
        
        $res = $game->getPlayer();
        $this->assertEquals( 1, $res);
    }
    public function testgetDeck(): void
    {
        $game = new BlackJack();
        $game->startGame(2,1);
        $res = $game->getDeck();
        $exp = 104;
        $this->assertEquals($exp, count($res));


    }
}
