<?php

namespace App\Repository;

use App\Entity\AidAdvisor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AidAdvisor|null find($id, $lockMode = null, $lockVersion = null)
 * @method AidAdvisor|null findOneBy(array $criteria, array $orderBy = null)
 * @method AidAdvisor[]    findAll()
 * @method AidAdvisor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AidAdvisorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AidAdvisor::class);
    }
}
