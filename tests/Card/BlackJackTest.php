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

}
