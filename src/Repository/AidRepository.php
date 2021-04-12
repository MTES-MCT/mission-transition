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
        EnvironmentalAction $environmentalAction,
        Region $region = null,
        string $perimeter = Aid::PERIMETER_NATIONAL,
        int $maxResults = 3
    ) {
        $qb = $this->createQueryBuilder('aid');

        $qb
            ->select('aid', 'environmentalActions', 'funder')
            ->join('aid.funder', 'funder')
            ->andWhere("aid.state = 'published'")
            ->andWhere('aid.perimeter = :perimeter')
            ->setParameter('perimeter', $perimeter)
            ->andWhere($qb->expr()->in('aid.type', $aidTypes))
            ->setMaxResults($maxResults)
        ;

        if (null !== $region) {
            $qb
                ->join('aid.regions', 'regions')
                ->andWhere('regions = :region')->setParameter('region', $region);
        }

        $qb
            ->join('aid.environmentalActions', 'environmentalActions')
            ->andWhere('environmentalActions = :environmentalAction')->setParameter('environmentalAction', $environmentalAction);

        return $qb->getQuery()->getResult();
    }

    public function countAids(
        array $aidTypes,
        EnvironmentalAction $environmentalAction,
        Region $region = null
    ) {
        $qb = $this->createQueryBuilder('aid');

        $qb
            ->select(
                'COUNT(aid) as total',
                'SUM(CASE WHEN aid.perimeter = \'REGIONAL\' THEN 1 ELSE 0 END) AS regional',
                'SUM(CASE WHEN aid.perimeter = \'NATIONAL\' THEN 1 ELSE 0 END) AS national'
            )
            ->andWhere($qb->expr()->in('aid.type', $aidTypes))
            ->andWhere("aid.state = 'published'")
        ;

        if (null !== $region) {
            $qb
                ->join('aid.regions', 'regions')
                ->andWhere('regions = :region')->setParameter('region', $region);
        }

        $qb
            ->join('aid.environmentalActions', 'environmentalActions')
            ->andWhere('environmentalActions = :environmentalAction')->setParameter('environmentalAction', $environmentalAction);

        //TODO avoid selecting array index manually
        return $qb->getQuery()->getScalarResult()[0];
    }
}
