<?php

namespace App\Entity;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Repository.
 */
class BookTest extends TestCase
{

    public function testBookCreate(): void
    {
        $book = new Book();
        
        $res = $book->getId(); 
        $this->assertNull($res,"value is not null");
    }

    public function testBookTitle(): void
    {
        $book = new Book();
        
        $res = $book->setTitle("phpUnitTest");
        $res = $book->getTitle();
        $exp = "phpUnitTest";
        $this->assertEquals($exp, $res);
    }

}