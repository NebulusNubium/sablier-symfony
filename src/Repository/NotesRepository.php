<?php

namespace App\Repository;

use App\Entity\Notes;
use App\Entity\Pictures;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Notes>
 */
class NotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notes::class);
    }

    public function findAverageForPicture(Pictures $picture): float
    {
        $qb = $this->createQueryBuilder('n')
            ->select('AVG(n.note)')
            ->join('n.picture', 'p')
            ->where('p = :pic')      
            ->setParameter('pic', $picture);

        $avg = $qb->getQuery()->getSingleScalarResult();

        return $avg !== null ? (float) $avg : 0.0;
    }

//    /**
//     * @return Notes[] Returns an array of Notes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Notes
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
