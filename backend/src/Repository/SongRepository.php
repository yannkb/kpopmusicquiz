<?php

namespace App\Repository;

use App\Entity\Song;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Song>
 */
class SongRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Song::class);
    }

    /**
     * @return array Returns an array of Song objects
     */
    public function findRandom(int $size = 10): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM song s
            ORDER BY RANDOM()
            LIMIT :size';

        $resultSet = $conn->executeQuery($sql, ['size' => $size]);

        return $resultSet->fetchAllAssociative();
    }

    //    public function findOneBySomeField($value): ?Song
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
