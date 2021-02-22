<?php

namespace App\Repository;

use App\Entity\EnvironmentalAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnvironmentalAction|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnvironmentalAction|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnvironmentalAction[]    findAll()
 * @method EnvironmentalAction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnvironmentalAction::class);
    }

    // /**
    //  * @return Tag[] Returns an array of Tag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tag
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}