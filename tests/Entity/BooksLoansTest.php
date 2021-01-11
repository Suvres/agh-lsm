<?php


namespace Entity;


use App\Entity\BookCopies;
use App\Entity\BooksLoans;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class BooksLoansTest extends TestCase
{
    public function testLoans(): void
    {
        $u = $this->createMock(User::class);
        $b = $this->createMock(BookCopies::class);

        $bl = new BooksLoans($u, $b);

        self::assertEquals($b, $bl->getBookCopy());
        self::assertEquals($u, $bl->getBorrower());
        self::assertNull($bl->getCommittedAt());

        $bl->returnBook();
        self::assertInstanceOf(\DateTime::class, $bl->getCommittedAt());
    }
}