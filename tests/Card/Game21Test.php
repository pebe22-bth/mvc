<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game21.
 */
class Game21Test extends TestCase
{
    public function testCreateGame21(): void
    {
        $game = new Game21();
        //        $this->assertInstanceOf("\App\Card\Game21", $game);

        $res = $game->getTurn();
        $exp = "player";
        $this->assertEquals($exp, $res);

        $res = $game->getWinner();
        $exp = null;
        $this->assertEquals($exp, $res);
    }

    public function testPlayerAndBankDraw(): void
    {
        $game = new Game21();
        //        $this->assertInstanceOf("\App\Card\Game21", $game);

        $res = $game->playerDraw();
        $this->assertTrue($res >= 1 && $res <= 36);

        $game->playerStop();
        $res = $game->getTurn();
        $exp = "bank";
        $this->assertEquals($exp, $res);

        $res = $game->bankDraw();
        $this->assertTrue($res >= 1 && $res <= 36);

        $res = $game->getWinner();
        $exp = null;
        $this->assertEquals($exp, $res);
    }

    public function testBankDrawTooEarly(): void
    {
        $game = new Game21();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Player has not stopped");
        $res = $game->bankDraw();

    }

    public function testPlayerDrawTooLate(): void
    {
        $game = new Game21();
        $game->playerDraw();
        $game->playerStop();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Player has stopped or game not started");
        $res = $game->playerDraw();
    }

    public function testGetPlayerAndBankHand(): void
    {
        $game = new Game21();
        $res = $game->playerDraw();
        $hand = $game->getPlayerHand();

        $res = $game->getHandValue($hand);
        $this->assertTrue($res >= 2 && $res <= 14);

        $game->playerStop();
        $game->bankDraw();
        $hand = $game->getBankHand();
        $res = $game->getHandValue($hand);
        $this->assertTrue($res >= 2 && $res <= 14);

    }
    public function testPlayerWinner(): void
    {
        $game = new Game21();
        for ($i = 0; $i < 10; $i++) {
            $res = $game->playerDraw();
        }
        $res = $game->getWinner();
        $exp = "bank";
        $this->assertEquals($exp, $res);
    }
    public function testBankWinner(): void
    {
        $game = new Game21();
        $res = $game->playerDraw();
        $game->playerStop();
        for ($i = 0; $i < 10; $i++) {
            $game->bankDraw();
        }
        $res = $game->getWinner();
        $exp = "player";
        $this->assertEquals($exp, $res);
    }
}
