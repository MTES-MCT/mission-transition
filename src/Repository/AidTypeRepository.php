<?php

namespace App\Repository;

use App\Entity\AidType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AidType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AidType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AidType[]    findAll()
 * @method AidType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AidTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AidType::class);
    }

    // /**
    //  * @return AidType[] Returns an array of AidType objects
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
    public function findOneBySomeField($value): ?AidType
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
