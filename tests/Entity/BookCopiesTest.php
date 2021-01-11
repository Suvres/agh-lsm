<?php


namespace Entity;


use App\Entity\Book;
use App\Entity\BookCopies;
use PHPUnit\Framework\TestCase;

class BookCopiesTest extends TestCase
{
    public function testBookCopies(): void
    {
        $book = $this->createMock(Book::class);
        $bookCopy = new BookCopies($book);

        self::assertEquals($book, $bookCopy->getBook());
    }
}