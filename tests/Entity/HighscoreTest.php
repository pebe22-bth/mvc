<?php

namespace App\Entity;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Repository.
 */
class HighscoreTest extends TestCase
{
    public function testHighscoreCreate(): void
    {
        $highscore = new Highscore();

        $res = $highscore->getId();
        $this->assertNull($res, "value is not null");
    }

    public function testHighscoreCategory(): void
    {
        $highscore = new Highscore();
        $player = new Player();
        $highscore->setCategory($player);
        $hplayer = $highscore->getCategory();
        $res = $hplayer->getId();
        $exp = $player->getId();
        $this->assertEquals($exp, $res);
    }

    public function testHighscoreCoins(): void
    {
        $highscore = new Highscore();

        $highscore->setCoins(1234);
        $res = $highscore->getCoins();
        $exp = 1234;
        $this->assertEquals($exp, $res);
    }



}
