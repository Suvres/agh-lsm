<?php

namespace Entity;

use App\Entity\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testBooks(): void
    {
        $books = new Book();
        $data = new \DateTime();

        $books->setAgeThreshold(12);
        $books->setAuthor('BłyszczyAutor');
        $books->setBrand(Book::DRAMAT);
        $books->setTitle('Tytul');
        $books->setCreatedAt($data);
        $books->setDeletedAt();

        self::assertEquals('BłyszczyAutor', $books->getAuthor());
        self::assertEquals(Book::DRAMAT, $books->getBrand());
        self::assertEquals('Tytul', $books->getTitle());
        self::assertEquals(12, $books->getAgeThreshold());
        self::assertEquals($data, $books->getCreatedAt());
    }
}
