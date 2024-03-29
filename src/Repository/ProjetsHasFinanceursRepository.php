<?php

namespace App\Repository;

use App\Entity\ProjetsHasFinanceurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * ProjetsHasFinanceursRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjetsHasFinanceursRepository  extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjetsHasFinanceurs::class);
    }

    public function findAllFinanceursFromProjetBuilder($id_projet)
    {
        return $this->createQueryBuilder('a','a.id')
            ->select ('a')
            ->innerJoin('a.financeur', 'b')
            ->where('a.projet = ?1')
            ->setParameter(1,$id_projet)
            ->orderBy('b.nom','ASC');
    }

    public function findAllFinanceursFromProjet ($id_projet)
    {
        return $this->findAllFinanceursFromProjetBuilder($id_projet)->getQuery()->getResult();
    }



    public function getArrayIdFromFinanceursPartenaires ($id_projet)
    {
        $result = [];
        $array  =  $this->findAllFinanceursFromProjet($id_projet);

        /**
         * @var  $key
         * @var ProjetsHasFinanceurs $value
         */
        foreach ($array as $key=>$value)
        {
            $id = $value->getFinanceur()->getId();
            $result[] = $id;
        }
        return $result;
    }

}
