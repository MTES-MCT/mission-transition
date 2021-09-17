<?php

namespace App\Repository;

use App\Entity\AidFeedback;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AidFeedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method AidFeedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method AidFeedback[]    findAll()
 * @method AidFeedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AidFeedbackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AidFeedback::class);
    }

    // /**
    //  * @return AidFeedback[] Returns an array of AidFeedback objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AidFeedback
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
