<?php

namespace App\Repository;

use App\Entity\Aid;
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

    public function getAidsArray()
    {
        $qb = $this->createQueryBuilder('aid');

        $qb
            ->select('aid', 'environmentalTopics', 'environmentalTopicCategories', 'funder')
            ->join('aid.funder', 'funder')
            ->andWhere('aid.applicationEndDate IS NULL OR aid.applicationEndDate >= :today')->setParameter('today', new \DateTime())
            ->join('aid.environmentalTopics', 'environmentalTopics')
            ->join('environmentalTopics.environmentalTopicCategories', 'environmentalTopicCategories')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    public function searchByCriteria(
        array $aidTypes,
        ?string $environmentalCategory = null,
        ?string $environmentalTopic = null,
        ?string $region = null,
        ?string $searchText = null,
        ?string $perimeter = 'REGIONAL',
        ?string $state = null
    ) {
        $qb = $this->createQueryBuilder('aid');

        $qb
            ->select('aid', 'environmentalTopics', 'environmentalTopicCategories', 'funder')
            ->join('aid.funder', 'funder')
            ->andWhere('aid.applicationEndDate IS NULL OR aid.applicationEndDate >= :today')->setParameter('today', new \DateTime())
            ->andWhere('aid.perimeter = :perimeter')->setParameter('perimeter', $perimeter)
        ;

        if (null !== $state) {
            $qb
                ->andWhere('aid.state = :state')->setParameter('state', $state);
        }

        if (null !== $region) {
            $qb
                ->join('aid.regions', 'regions')
                ->andWhere('regions IN (:regions)')->setParameter('regions', $region);
        }

        $qb
            ->join('aid.environmentalTopics', 'environmentalTopics')
            ->join('environmentalTopics.environmentalTopicCategories', 'environmentalTopicCategories')
        ;

        if (null !== $environmentalCategory) {
            $qb->andWhere('environmentalTopicCategories = :category')->setParameter('category', $environmentalCategory);
        }

        if (!empty($aidTypes)) {
            $qb
                ->join('aid.types', 'types')
                ->andWhere('types IN (:types)')->setParameter('types', $aidTypes);
        }

        if (null !== $environmentalTopic) {
            $qb
                ->andWhere('environmentalTopics = :topic')->setParameter('topic', $environmentalTopic);
        }

        if (null !== $searchText) {
            $qb
                ->andWhere('LOWER(aid.name) LIKE :text OR LOWER(aid.aidDetails) LIKE :text OR LOWER(aid.contactGuidelines) LIKE :text')->setParameter('text', '%'.strtolower($searchText).'%')
            ;
        }

        return $qb->getQuery()->getResult();
    }

    public function countAids(
        array $aidTypes,
        EnvironmentalTopic $environmentalTopic,
        Region $region = null
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
