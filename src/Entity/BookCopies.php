<?php

namespace App\Entity;

use App\Repository\BookCopiesRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass=BookCopiesRepository::class)
 */
class BookCopies
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $hashcode;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="bookCopies")
     * @ORM\JoinColumn(nullable=false)
     */
    private Book $book;

    /**
     * @ORM\OneToMany(targetEntity=BooksLoans::class, mappedBy="bookCopy")
     */
    private PersistentCollection $booksLoans;

    /**
     * BookCopies constructor.
     * @param Book $book
     */
    public function __construct(Book $book)
    {
        $this->hashcode = substr(hash('sha256', time()), 0, 25);
        $this->book = $book;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHashcode(): string
    {
        return $this->hashcode;
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    /**
     * @return PersistentCollection|BooksLoans[]
     */
    public function getBooksLoans(): PersistentCollection
    {
        return $this->booksLoans;
    }

    public function addBooksLoan(BooksLoans $booksLoan): self
    {
        if (!$this->booksLoans->contains($booksLoan)) {
            $this->booksLoans[] = $booksLoan;
        }

        return $this;
    }
}
