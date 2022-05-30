<?php

namespace App\Repository;

use App\Entity\EtatAvancementProjet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EtatAvancementProjet|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtatAvancementProjet|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtatAvancementProjet[]    findAll()
 * @method EtatAvancementProjet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatAvancementProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatAvancementProjet::class);
    }

    // /**
    //  * @return EtatAvancementProjet[] Returns an array of EtatAvancementProjet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EtatAvancementProjet
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
