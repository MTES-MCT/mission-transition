<?php

namespace App\Repository;

use App\Entity\Funder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Funder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Funder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Funder[]    findAll()
 * @method Funder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FunderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Funder::class);
    }
}
