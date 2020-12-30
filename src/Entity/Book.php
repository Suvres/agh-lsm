<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
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
    private string $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="integer")
     */
    private int $ageThreshold;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $brand;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity=BookCopies::class, mappedBy="book", orphanRemoval=true)
     */
    private $bookCopies;

    /**
     * Book constructor.
     * @param string $author
     * @param string $title
     * @param int $ageThreshold
     * @param string $brand
     */
    public function __construct(string $author, string $title, int $ageThreshold, string $brand)
    {
        $this->author = $author;
        $this->title = $title;
        $this->ageThreshold = $ageThreshold;
        $this->brand = $brand;
        $this->createdAt = new \DateTime();
        $this->bookCopies = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAgeThreshold(): int
    {
        return $this->ageThreshold;
    }

    public function setAgeThreshold(int $ageThreshold): void
    {
        $this->ageThreshold = $ageThreshold;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return Collection|BookCopies[]
     */
    public function getBookCopies(): Collection
    {
        return $this->bookCopies;
    }

    public function addBookCopy(BookCopies $bookCopy): self
    {
        if (!$this->bookCopies->contains($bookCopy)) {
            $this->bookCopies[] = $bookCopy;
        }

        return $this;
    }

    public function removeBookCopy(BookCopies $bookCopy): void
    {
       throw new Exception("TODO");
    }
}
