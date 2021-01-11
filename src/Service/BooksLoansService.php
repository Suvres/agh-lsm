<?php

namespace App\Service;

use App\DTO\BookLoanDTO;
use App\Entity\Book;
use App\Entity\BookCopies;
use App\Entity\BooksLoans;
use App\Repository\BooksLoansRepository;
use Doctrine\ORM\EntityManagerInterface;

class BooksLoansService
{
    private EntityManagerInterface $entityManager;

    private BooksLoansRepository $booksLoansRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        BooksLoansRepository $booksLoansRepository
    ) {
        $this->booksLoansRepository = $booksLoansRepository;
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
        } elseif ($this->booksLoansRepository->findForUserInLoans($bookLoanDTO->getUser())->count() < Book::BOOK_LIMITS) {
            $canBorrow = true;
        }

        if ($canBorrow) {
            $bc = new BooksLoans($bookLoanDTO->getUser(), $bookCopies);
            $this->entityManager->persist($bc);

            return true;
        }

        return false;
    }

    public function isAvailable(Book $book): bool
    {
        $loans = true;
        foreach ($book->getBookCopies() as $copy) {
            foreach ($copy->getBooksLoans() as $loan) {
                if ($loan->getCommittedAt() === null) {
                    $loans = false;
                    break;
                }
            }
        }

        return $book->getDeletedAt() === null && $book->getBookCopies()->count() > 0 && !$loans;
    }
}
