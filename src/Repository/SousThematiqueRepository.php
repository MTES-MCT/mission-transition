<?php

namespace App\Repository;

use App\Entity\SousThematique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SousThematique|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousThematique|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousThematique[]    findAll()
 * @method SousThematique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousThematiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SousThematique::class);
    }

    // /**
    //  * @return SousThematique[] Returns an array of SousThematique objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SousThematique
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
