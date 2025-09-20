<?php

namespace App\Repository;

use App\Entity\Highscore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Highscore>
 */
class HighscoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Highscore::class);
    }

        
    /**
     * getHighscores
     *
     * @return array
     */
    public function getHighscores(): array
    {
    return $this->createQueryBuilder('h')
        ->select('p.name AS player_name', 'h.coins')
        ->join('h.category', 'p') 
        ->orderBy('h.coins', 'DESC')
        ->setMaxResults(10)
        ->getQuery()
        ->getArrayResult();
    }

    //    public function findOneBySomeField($value): ?Highscore
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
