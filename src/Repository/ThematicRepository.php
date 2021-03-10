<?php

namespace App\Repository;

use App\Entity\EnvironmentalTopic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnvironmentalTopic|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnvironmentalTopic|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnvironmentalTopic[]    findAll()
 * @method EnvironmentalTopic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThematicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnvironmentalTopic::class);
    }
}
