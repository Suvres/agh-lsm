<?php

namespace App\Repository;

use App\Entity\BookCopies;
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

    // /**
    //  * @return BookCopies[] Returns an array of BookCopies objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookCopies
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
