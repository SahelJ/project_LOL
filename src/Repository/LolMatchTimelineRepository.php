<?php

namespace App\Repository;

use App\Entity\LolMatchTimeline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LolMatchTimeline>
 *
 * @method LolMatchTimeline|null find($id, $lockMode = null, $lockVersion = null)
 * @method LolMatchTimeline|null findOneBy(array $criteria, array $orderBy = null)
 * @method LolMatchTimeline[]    findAll()
 * @method LolMatchTimeline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LolMatchTimelineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LolMatchTimeline::class);
    }

    public function add(LolMatchTimeline $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LolMatchTimeline $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LolMatchTimeline[] Returns an array of LolMatchTimeline objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LolMatchTimeline
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
