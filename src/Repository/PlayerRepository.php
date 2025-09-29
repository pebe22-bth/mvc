<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Player>
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }
    /**
     * findName
     *
     * @param  mixed $value
     * @return Player
     */
    public function findName($value): ?Player
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name = :val')
            ->setParameter('val', $value)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    /**
     * findId
     *
     * @param  int $value
     * @return Player
     */
    public function findId($value): ?Player
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    /**
     * findAllPlayers
     *
     * @return array<mixed>
     */
    public function findAllPlayers(): ?array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.name, p.coins')
            ->getQuery()
            ->getArrayResult()
        ;
    }
    public function reset(): void
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "
            DELETE FROM highscore;
            ";
        $conn->executeQuery($sql);

        $sql = "
            DELETE FROM player;
            ";
        $conn->executeQuery($sql);

        $sql = "
            UPDATE SQLITE_SEQUENCE SET SEQ=0 WHERE ( NAME='highscore' OR NAME='player');
            ";
        $conn->executeQuery($sql);

        $sql = "
            INSERT INTO player (name, coins) 
            VALUES
                ('Lisa','7'),
                ('Pelle','11'),
                ('Berra','28');
            ";
        $conn->executeQuery($sql);
        $sql = "
            INSERT INTO highscore (category_id, coins) 
            VALUES
                ((SELECT id from player WHERE name = 'Lisa'),'10'),
                ((SELECT id from player WHERE name = 'Pelle'),'32'),
                ((SELECT id from player WHERE name = 'Berra'),'29');
            ";
        $conn->executeQuery($sql);

    }
    //    /**
    //     * @return Player[] Returns an array of Player objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Player
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
