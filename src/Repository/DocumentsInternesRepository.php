<?php

namespace App\Repository;

use App\Entity\DocumentsInternes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocumentsInternes>
 *
 * @method DocumentsInternes|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentsInternes|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentsInternes[]    findAll()
 * @method DocumentsInternes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentsInternesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentsInternes::class);
    }

    public function save(DocumentsInternes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DocumentsInternes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DocumentsInternes[] Returns an array of DocumentsInternes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DocumentsInternes
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
