<?php

namespace App\Repository;

use App\Entity\MailingList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MailingList>
 */
class MailingListRepository extends ServiceEntityRepository
{
    /**
     * Constructeur de la classe MailingListRepository.
     *
     * @param ManagerRegistry $registry Le registre de gestion des entités.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MailingList::class);
    }

    /**
     * Recherche et retourne un tableau d'objets MailingList correspondant à un champ d'exemple donné.
     *
     * @param mixed $value La valeur à rechercher dans le champ d'exemple.
     *
     * @return MailingList[] Un tableau d'objets MailingList correspondant au critère de recherche.
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Recherche et retourne un objet MailingList correspondant à un champ donné.
     *
     * @param mixed $value La valeur à rechercher dans le champ spécifié.
     *
     * @return MailingList|null L'objet MailingList correspondant au critère de recherche, ou null si aucun résultat.
     *
     * @throws NonUniqueResultException
     */
    public function findOneBySomeField($value): ?MailingList
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
