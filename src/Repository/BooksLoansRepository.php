<?php

namespace App\Repository;

use App\Entity\BooksLoans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BooksLoans|null find($id, $lockMode = null, $lockVersion = null)
 * @method BooksLoans|null findOneBy(array $criteria, array $orderBy = null)
 * @method BooksLoans[]    findAll()
 * @method BooksLoans[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BooksLoansRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BooksLoans::class);
    }

    public function findAllInLoans(int $max): ArrayCollection
    {
        $qb = $this->createQueryBuilder("b")
            ->andWhere("b.committedAt is null")
            ->orderBy("b.startedAt", "DESC")
            ->setMaxResults($max)
            ->getQuery()->getResult();

        return new ArrayCollection($qb);
    }
}
