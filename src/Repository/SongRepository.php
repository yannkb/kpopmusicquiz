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
     * @return Song[] Returns an array of Song objects
     */
    public function findRandom(int $numberOfTracks): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM song s
            ORDER BY RANDOM()
            LIMIT :limit OFFSET (SELECT ABS(RANDOM()) % (SELECT COUNT(*) FROM song))
            ';

        $resultSet = $conn->executeQuery($sql, ['limit' => $numberOfTracks]);

        // returns an array of arrays (i.e. a raw data set)
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
