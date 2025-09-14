<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }
    public function findByIsbn(string $isbn): ?Book
    {
        /** @phpstan-ignore-next-line */
        return $this->createQueryBuilder('b')
            ->andWhere('b.isbn = :val')
            ->setParameter('val', $isbn)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function reset(): void
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "
            DELETE FROM book;
            ";
        $conn->executeQuery($sql);

        $sql = "
            INSERT INTO book (title, isbn, author, image) 
            VALUES
                ('Around the World in Eighty Days','978-1949460858','Jules Verne','80days.jpg'),
                ('Krig och fred. Vol 1, 1805','978-9174619249','Leo Tolstoy','kf1.jpg'),
                ('Krig och fred. Vol 2, 1806-1812','978-9174619256','Leo Tolstoy','kf2.jpg'),
                ('Krig och fred. Vol 3, 1812','978-9174619263','Leo Tolstoy','kf3.jpg'),
                ('Krig och fred. Vol 4, 1812-1813 / Epilog','978-9174619270','Leo Tolstoy','kf4.jpg');
            ";
        $conn->executeQuery($sql);

    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
