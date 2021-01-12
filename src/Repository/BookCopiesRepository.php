<?php

namespace App\Repository;

use App\Entity\BookCopies;
use App\Entity\BooksLoans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookCopies|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookCopies|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookCopies[]    findAll()
 * @method BookCopies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookCopiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookCopies::class);
    }

    /**
     * @return BooksLoans[]
     */
    public function findNonDelete(): array
    {
        return $this->createQueryBuilder('l')
            ->leftJoin('l.book', 'b')->addSelect('b')
            ->where('b.deletedAt is null')
            ->orderBy('b.title', 'ASC')
            ->getQuery()->getResult();
    }
}
