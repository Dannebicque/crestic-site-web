<?php

namespace App\Repository;

use App\Entity\ProjetsHasMembres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * ProjetsHasMembresRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjetsHasMembresRepository  extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjetsHasMembres::class);
    }


    public function findAllMembresFromProjetBuilder($id_projet)
    {
        return $this->createQueryBuilder('a','a.id')
            ->select ('a')
            ->where('a.projet = ?1')
            ->innerJoin('a.membreCrestic','b')
            ->orderBy('b.nom','asc')
            ->setParameter(1,$id_projet);
    }

    public function findAllMembresFromProjet ($id_projet)
    {
        return $this->findAllMembresFromProjetBuilder($id_projet)->getQuery()->getResult();
    }

    public function getArrayIdFromProjetsMembres ($id_projet)
    {
        $result = [];
        $array  =  $this->findAllMembresFromProjet($id_projet);

        foreach ($array as $key=>$value)
        {
            $id = $value->getMembreCrestic()->getId();
            $result[] = $id;
        }
        return $result;
    }


}
