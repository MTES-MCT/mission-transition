<?php

namespace App\Repository;

use App\Entity\Aid;
use App\Entity\EnvironmentalAction;
use App\Entity\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
        array $aidTypes,
        EnvironmentalAction $environmentalAction = null,
        array $businessActivityAreaIds = null,
        Region $region = null
    ) {
        $qb = $this->createQueryBuilder('aid');

        if (null === $environmentalAction) {
            return [];
        }

        if (!empty($businessActivityAreaIds)) {
            $qb
                ->leftJoin('aid.businessActivityAreas', 'businessActivityAreas')
                ->andWhere($qb->expr()->in('businessActivityAreas', $businessActivityAreaIds));
        }

        if (null !== $region) {
            $qb
                ->andWhere('aid.region = :region')->orWhere('aid.perimeter = :perimeter')->setParameter('perimeter', 'NATIONAL')
                ->setParameter('region', $region)
            ;
        }

        $qb
            ->andWhere("aid.state = 'published'")
            ->andWhere('aid.perimeter = :regional OR aid.perimeter = :national')
            ->setParameter('regional', 'REGIONAL')
            ->setParameter('national', 'NATIONAL')
            ->andWhere($qb->expr()->in('aid.type', $aidTypes));

        $qb
            ->join('aid.environmentalActions', 'environmentalActions')
            ->andWhere('environmentalActions = :environmentalAction')->setParameter('environmentalAction', $environmentalAction);

        return $qb->getQuery()->getResult();
    }
}
