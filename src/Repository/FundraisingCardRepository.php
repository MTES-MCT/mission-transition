<?php

namespace App\Repository;

use App\Entity\FundraisingCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FundraisingCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method FundraisingCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method FundraisingCard[]    findAll()
 * @method FundraisingCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FundraisingCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FundraisingCard::class);
    }

    // /**
    //  * @return FundraisingCard[] Returns an array of FundraisingCard objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FundraisingCard
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
