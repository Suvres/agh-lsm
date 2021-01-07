<?php

namespace App\Service;

use App\DTO\BookLoanDTO;
use App\Entity\BookCopies;
use App\Entity\BooksLoans;
use Doctrine\ORM\EntityManagerInterface;

class BooksLoansService
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function isInLoans(BookCopies $bookCopies): ?BooksLoans
    {
        $copies = $bookCopies->getBooksLoans();
        $loan = $copies->filter(function (BooksLoans $booksLoans) {
            return $booksLoans->getCommittedAt() === null;
        })->first();

        return $loan instanceof BooksLoans ? $loan : null;
    }

    public function borrow(BookLoanDTO $bookLoanDTO, BookCopies $bookCopies): bool
    {
        if ($this->isInLoans($bookCopies)) {
            return false;
        }

        $canBorrow = false;
        if (\in_array('ROLE_ADMIN', $bookLoanDTO->getUser()->getRoles(), true)) {
            $canBorrow = true;
        }

        if ($canBorrow) {
            $bc = new BooksLoans($bookLoanDTO->getUser(), $bookCopies);
            $this->entityManager->persist($bc);

            return true;
        }

        return false;
    }
}
