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
    
    public function testBookIsbn(): void
    {
        $book = new Book();
        
        $res = $book->setIsbn("12345678");
        $res = $book->getIsbn();
        $exp = "12345678";
        $this->assertEquals($exp, $res);
    }
    
    public function testBookAuthor(): void
    {
        $book = new Book();
        
        $res = $book->setAuthor("Author");
        $res = $book->getAuthor();
        $exp = "Author";
        $this->assertEquals($exp, $res);
    }
    
    public function testBookImage(): void
    {
        $book = new Book();
        
        $res = $book->setImage("path/to/image/12345678");
        $res = $book->getImage();
        $exp = "path/to/image/12345678";
        $this->assertEquals($exp, $res);
    }

}