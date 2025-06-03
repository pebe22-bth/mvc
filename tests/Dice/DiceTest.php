<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceTest extends TestCase
{
    public function testCreateDice():void
    {
        $dice = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $dice);
        $res = $dice->getValue();
        $exp = null;
        $this->assertEquals($exp, $res);
    }

    public function testCreatedDiceRoll():void
    {
        $dice = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $dice);

        $res = $dice->roll();
        $this->assertIsInt($res);

        $res = $dice->getValue();
        $this->assertTrue($res >= 1 && $res <= 6);

        $res = $dice->getAsString();
        $this->assertNotEmpty($res);

    }

}
