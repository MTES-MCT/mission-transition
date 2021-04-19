<?php

namespace App\Repository;

use App\Entity\EnvironmentalActionCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnvironmentalActionCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnvironmentalActionCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnvironmentalActionCategory[]    findAll()
 * @method EnvironmentalActionCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnvironmentalActionCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnvironmentalActionCategory::class);
    }
}
