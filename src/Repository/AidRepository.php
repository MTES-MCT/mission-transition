<?php

namespace App\Repository;

use App\Entity\Aid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Aid|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aid|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aid[]    findAll()
 * @method Aid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aid::class);
    }

    public function searchByCriteria(
        array $environmentalActionIds = null,
        array $businessActivityAreaIds = null,
        string $regionName = null
    ){
        $qb = $this->createQueryBuilder('aid');

        if (empty($environmentalActionIds)) {
            return [];
        }

        if (!empty($environmentalActionIds)) {
            $qb
                ->join('aid.environmentalActions', 'environmentalActions')
                ->add('where', $qb->expr()->in('environmentalActions', $environmentalActionIds));
        }

        if (!empty($businessActivityAreaIds)) {
            $qb
                ->leftJoin('aid.businessActivityAreas', 'businessActivityAreas')
                ->add('where', $qb->expr()->in('businessActivityAreas', $businessActivityAreaIds));
        }

        if (null !== $regionName) {
            $qb
                ->andWhere('aid.regionName LIKE :regionName')
                ->setParameter('regionName', '%'.addcslashes($regionName, '_%').'%')
                ;
        }

        $qb->andWhere("aid.state = 'published'");

        return $qb->getQuery()->getResult();
    }
}
