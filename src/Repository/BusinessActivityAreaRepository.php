<?php

namespace App\Repository;

use App\Entity\BusinessActivityArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BusinessActivityArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusinessActivityArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method BusinessActivityArea[]    findAll()
 * @method BusinessActivityArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusinessActivityAreaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BusinessActivityArea::class);
    }
}
