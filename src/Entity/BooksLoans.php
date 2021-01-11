<?php

namespace App\Entity;

use App\Repository\BooksLoansRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BooksLoansRepository::class)
 */
class BooksLoans
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="booksLoans")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $borrower;

    /**
     * @ORM\ManyToOne(targetEntity=BookCopies::class, inversedBy="booksLoans")
     */
    private BookCopies $bookCopy;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $startedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $committedAt;

    public function __construct(User $borrower, BookCopies $bookCopy)
    {
        $this->borrower = $borrower;
        $this->bookCopy = $bookCopy;
        $this->startedAt = new \DateTime();
        $this->committedAt = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorrower(): ?User
    {
        return $this->borrower;
    }

    public function getBookCopy(): ?BookCopies
    {
        return $this->bookCopy;
    }

    public function getStartedAt(): \DateTime
    {
        return $this->startedAt;
    }

    public function getCommittedAt(): ?\DateTime
    {
        return $this->committedAt;
    }

    public function setCommittedAt(\DateTime $committedAt): void
    {
        $this->committedAt = $committedAt;
    }

    public function returnBook(): void
    {
        $this->committedAt = new \DateTime();
    }
}
