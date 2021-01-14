<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return Book[]
     */
    public function findNonDelete(): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.deletedAt IS NULL')
            ->getQuery()->getResult();
    }

    public function findNonDeleteForUser(User $getUser): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.deletedAt IS NULL')
            ->andWhere('b.ageThreshold <= :y')->setParameter('y', $getUser->getBirthDate()->diff(new \DateTime())->format('%y'))
            ->getQuery()->getResult();
    }
}
