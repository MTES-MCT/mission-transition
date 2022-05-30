<?php

namespace App\Repository;

use App\Entity\RecurrenceAide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecurrenceAide|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecurrenceAide|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecurrenceAide[]    findAll()
 * @method RecurrenceAide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecurrenceAideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecurrenceAide::class);
    }

    // /**
    //  * @return RecurrenceAide[] Returns an array of RecurrenceAide objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecurrenceAide
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
