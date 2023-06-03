<?php

namespace App\Repository;

use App\Entity\InternshipSupervisor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InternshipSupervisor>
 *
 * @method InternshipSupervisor|null find($id, $lockMode = null, $lockVersion = null)
 * @method InternshipSupervisor|null findOneBy(array $criteria, array $orderBy = null)
 * @method InternshipSupervisor[]    findAll()
 * @method InternshipSupervisor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InternshipSupervisorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InternshipSupervisor::class);
    }

    public function save(InternshipSupervisor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InternshipSupervisor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return InternshipSupervisor[] Returns an array of InternshipSupervisor objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InternshipSupervisor
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
