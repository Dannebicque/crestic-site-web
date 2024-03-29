<?php

namespace App\Repository;

use App\Entity\Emplois;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * EmploisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EmploisRepository  extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emplois::class);
    }

    public function findAll()
    {
        return $this->findBy([], ['updated' => 'desc']);
    }
}
