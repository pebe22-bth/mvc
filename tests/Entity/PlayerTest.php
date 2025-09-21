<?php

namespace App\Entity;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Repository.
 */
class PlayerTest extends TestCase
{
    public function testPlayerCreate(): void
    {
        $player = new Player();

        $res = $player->getId();
        $this->assertNull($res, "value is not null");
    }

    public function testPlayerName(): void
    {
        $player = new Player();

        $player->setName("phpUnitTest2");
        $res = $player->getName();
        $exp = "phpUnitTest2";
        $this->assertEquals($exp, $res);
    }

    public function testPlayerCoins(): void
    {
        $player = new Player();

        $player->setCoins(1234);
        $res = $player->getCoins();
        $exp = 1234;
        $this->assertEquals($exp, $res);
    }



}
