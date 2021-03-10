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
class ActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnvironmentalAction::class);
    }
}
