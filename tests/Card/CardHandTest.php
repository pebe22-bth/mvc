<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game21.
 */
class CardHandTest extends TestCase
{
    public function testCardHand():void
    {
        $hand = new CardHand();
        foreach ([1,12,23,34,45] as $i) {
            $card = new CardGraphic();
            $res = $card->set($i);
            $hand->add($card);
        }
//        $this->assertInstanceOf("\App\Card\CardHand", $hand);
        $res = $hand->getNumberCards();
        $exp = 5;
        $this->assertEquals($exp, $res);

        $res = $hand->getValues();
        $exp = [1, 12, 23, 34, 45];
        $this->assertEquals($exp, $res);

        $res = $hand->getString();
        $exp = ['2♠', 'K♠','J♥','9♦','7♣'];
        $this->assertEquals($exp, $res);
    }

    public function testCardGraphic():void
    {
        $card = new CardGraphic();
//        $this->assertInstanceOf("\App\Card\CardGraphic", $card);

        $res = $card->getValue();
        $exp = null;
        $this->assertEquals($exp, $res);

        $res = $card->set(10);
        $exp = 10;
        $this->assertEquals($exp, $res);

        $res = $card->getAsString();
        $exp = 'J♠';
        $this->assertEquals($exp, $res);
    }

}
