<?php

namespace App\Repository;

use App\Entity\Aid;
use App\Entity\EnvironmentalAction;
use App\Entity\EnvironmentalTopic;
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
        EnvironmentalTopic $environmentalTopic,
        Region $region = null,
        string $perimeter = Aid::PERIMETER_NATIONAL,
        int $maxResults = 6
    ) {
        $qb = $this->createQueryBuilder('aid');


        $qb
            ->select('aid', 'environmentalTopics', 'funder')
            ->join('aid.funder', 'funder')
            ->setMaxResults($maxResults)
        ;

        if (null !== $region) {
            $qb
                ->join('aid.regions', 'regions')
                ->andWhere('regions = :region')->setParameter('region', $region);
        }

        $qb
            ->join('aid.environmentalTopics', 'environmentalTopics')
            ->andWhere('environmentalTopics = :environmentalTopic')->setParameter('environmentalTopic', $environmentalTopic);

        return $qb->getQuery()->getResult();
    }

    public function countAids(
        array              $aidTypes,
        EnvironmentalTopic $environmentalTopic,
        Region             $region = null
    ) {
        $qb = $this->createQueryBuilder('aid');

        $qb
            ->select(
                'COUNT(aid) as total',
                'SUM(CASE WHEN aid.perimeter = \'REGIONAL\' THEN 1 ELSE 0 END) AS regional',
                'SUM(CASE WHEN aid.perimeter = \'NATIONAL\' THEN 1 ELSE 0 END) AS national'
            )
            ->andWhere("aid.state = 'published'")
        ;

        if (null !== $region) {
            $qb
                ->join('aid.regions', 'regions')
                ->andWhere('regions = :region')->setParameter('region', $region);
        }

        $qb
            ->join('aid.environmentalTopics', 'environmentalTopics')
            ->andWhere('environmentalTopics = :environmentalTopic')->setParameter('environmentalTopic', $environmentalTopic);

        //TODO avoid selecting array index manually
        return $qb->getQuery()->getScalarResult()[0];
    }
}
