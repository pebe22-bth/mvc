<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game21.
 */
class CardGraphicTest extends TestCase
{
    public function testCard(): void
    {
        $card = new Card();
        //        $this->assertInstanceOf("\App\Card\Card", $card);

        $res = $card->set(10);
        $exp = 10;
        $this->assertEquals($exp, $res);

        $res = $card->getAsString();
        $exp = '[10]';
        $this->assertEquals($exp, $res);
    }

    public function testCardGraphic(): void
    {
        $card = new CardGraphic();
        //        $this->assertInstanceOf("\App\Card\CardGraphic", $card);

        $res = $card->getValue();
        $exp = null;
        $this->assertEquals($exp, $res);

        $res = $card->getAsString();
        $exp = '[]';
        $this->assertEquals($exp, $res);

        $res = $card->set(10);
        $exp = 10;
        $this->assertEquals($exp, $res);

        $res = $card->getAsString();
        $exp = 'J♠';
        $this->assertEquals($exp, $res);
    }

}
