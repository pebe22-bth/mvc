<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game21.
 */
class Game21Test extends TestCase
{
    public function testCreateGame21():void
    {
        $game = new Game21();
        $this->assertInstanceOf("\App\Card\Game21", $game);

        $res = $game->getTurn();
        $exp = "player";
        $this->assertEquals($exp, $res);

        $res = $game->getWinner();
        $exp = null;
        $this->assertEquals($exp, $res);
    }

    public function testPlayerAndBankDraw():void
    {
        $game = new Game21();
        $this->assertInstanceOf("\App\Card\Game21", $game);

        $res = $game->playerDraw();
        $this->assertIsInt($res);

        $game->playerStop();
        $res = $game->getTurn();
        $exp = "bank";
        $this->assertEquals($exp, $res);

        $res = $game->bankDraw();
        $this->assertIsInt($res);

        $res = $game->getWinner();
        $exp = null;
        $this->assertEquals($exp, $res);
    }

    public function testBankDrawTooEarly():void
    {
        $game = new Game21();
        $this->expectException(\Exception::class);
        $res = $game->bankDraw();
        $exp = expectExceptionMessage("Player has not stopped");
        $this->assertEquals($exp, $res);

    }

    public function testPlayerDrawTooLate():void
    {
        $game = new Game21();
        $res = $game->playerDraw();
        $res = $game->playerStop();
        $this->expectException(\Exception::class);
        $res = $game->playerDraw();
        $exp = expectExceptionMessage("Player has stopped or game not started");
        $this->assertEquals($exp, $res);

    }

    public function testGetPlayerAndBankHand()
    {
        $game = new Game21();
        $res = $game->playerDraw();
        $hand = $game->getPlayerHand();
        $this->assertInstanceOf("\App\Card\CardHand", $hand);

        $res = $game->getHandValue($hand);
        $this->assertTrue($res >= 2 && $res <= 14);

        $res = $game->playerStop();
        $res = $game->bankDraw();
        $hand = $game->getBankHand();
        $this->assertInstanceOf("\App\Card\CardHand", $hand);
        $res = $game->getHandValue($hand);
        $this->assertTrue($res >= 2 && $res <= 14);

    }
    public function testPlayerWinner()
    {
        $game = new Game21();
        for ($i = 0; $i < 10; $i++) {
            $res = $game->playerDraw();
        }
        $res = $game->getWinner();
        $exp = "bank";
        $this->assertEquals($exp, $res);
    }
    public function testBankWinner()
    {
        $game = new Game21();
        $res = $game->playerDraw();
        $res = $game->playerStop();
        for ($i = 0; $i < 10; $i++) {
            $res = $game->bankDraw();
        }
        $res = $game->getWinner();
        $exp = "player";
        $this->assertEquals($exp, $res);
    }
}
