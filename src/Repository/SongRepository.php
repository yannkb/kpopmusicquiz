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
     * @return array Returns a Song object
     */
    public function findOneRandom(array $excludedSongsIds = []): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM song s
            ';
        if (!empty($excludedSongsIds)) {
            $sql .= '
            WHERE id NOT IN (:excludedSongsIds)
        ';
        }
        $sql .= '
            ORDER BY RANDOM()
            LIMIT 1 OFFSET (SELECT ABS(RANDOM()) % (SELECT COUNT(*) FROM song))
            ';

        $resultSet = $conn->executeQuery($sql, ['excludedSongsIds' => $excludedSongsIds]);

        return $resultSet->fetchAssociative();
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
