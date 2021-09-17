<?php

namespace App\Repository;

use App\Entity\EnvironmentalTopicCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnvironmentalTopicCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnvironmentalTopicCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnvironmentalTopicCategory[]    findAll()
 * @method EnvironmentalTopicCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnvironmentalTopicCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnvironmentalTopicCategory::class);
    }


    public function findAllWithTopics()
    {
        return $this->createQueryBuilder('etc')
            ->select('etc', 'et')
            ->leftJoin('etc.environmentalTopics', 'et')
            ->orderBy('etc.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return EnvironmentalTopicCategory[] Returns an array of EnvironmentalTopicCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EnvironmentalTopicCategory
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
