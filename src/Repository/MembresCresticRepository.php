<?php

namespace App\Repository;

use App\Entity\MembresCrestic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MembresCrestic>
 */
class MembresCresticRepository extends ServiceEntityRepository
{
    /**
     * Constructeur de la classe MembresCresticRepository.
     *
     * @param ManagerRegistry $registry Le registre de gestion des entités.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MembresCrestic::class);
    }

    /**
     * Retourne les noms et prénoms de tous les membres.
     *
     * @return array Les noms et prénoms de tous les membres triés par nom et prénom.
     */
    public function findAll(): array
    {
        return $this->findBy([], ['nom' => 'ASC', 'prenom' => 'ASC']);
    }

    /**
     * Retourne les membres dont le nom commence par une lettre spécifique, en excluant les anciens membres.
     * La recherche est insensible à la casse.
     *
     * @param string $lettre La lettre par laquelle le nom des membres doit commencer.
     *
     * @return array Les membres correspondant à la lettre spécifiée.
     */
    public function findByLettre(string $lettre): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.nom LIKE :lettre')
            ->orWhere('m.nom LIKE :lettre2')
            ->andWhere('m.ancienMembresCrestic = false')
            ->setParameters(['lettre'=> $lettre.'%', 'lettre2' => strtolower($lettre).'%'])
            ->orderBy('m.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne les membres qui ont un identifiant HAL.
     *
     * @return array Les membres qui ont un identifiant HAL.
     */
    public function findWithIdHal(): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.idhal IS NOT NULL')
            ->orderBy('m.nom', 'ASC')
            ->addOrderBy('m.prenom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne les anciens membres dont le nom commence par une lettre spécifique.
     * La recherche est insensible à la casse.
     *
     * @param string $lettre La lettre par laquelle le nom des anciens membres doit commencer.
     *
     * @return array Les anciens membres correspondant à la lettre spécifiée.
     */
    public function findByExLettre(string $lettre): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.nom LIKE :lettre')
            ->orWhere('m.nom LIKE :lettre2')
            ->andWhere('m.ancienMembresCrestic = true')
            ->setParameters(['lettre'=> $lettre.'%', 'lettre2' => strtolower((string) $lettre).'%'])
            ->orderBy('m.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Génère un QueryBuilder pour récupérer tous les membres.
     * Si une option de rôle est fournie, filtre les résultats en fonction de ce rôle.
     *
     * @param array|null $array_options Options pour filtrer les résultats.
     *
     * @return QueryBuilder|null QueryBuilder pour récupérer les membres Crestic, ou null si les options sont invalides.
     */
    public function findAllMembresCresticBuilder(array|null $array_options = null): ?QueryBuilder
    {
        $result = null;
        if (is_array($array_options) && array_key_exists('role', $array_options)) {
            $result = match ($array_options['role']) {
                'ROLE_RESPONSABLE', 'ROLE_UTILISATEUR' => $this->createQueryBuilder('a', 'a.id')
                    ->where('a.id = ?1 and a.ancienMembresCrestic = false')
                    ->orderBy('a.nom', 'ASC')
                    ->setParameter(1, $array_options['user_id']),
                default => $this->createQueryBuilder('a', 'a.id')
                    ->where('a.ancienMembresCrestic = false')
                    ->orderBy('a.nom', 'ASC'),
            };
        } else {
            $result = $this->createQueryBuilder('a', 'a.id')
                ->where('a.ancienMembresCrestic = false')
                ->orderBy('a.nom', 'ASC')
            ;
        }

        return $result;
    }

    /**
     * Retourne tous les membres.
     * Si une option de rôle est fournie, filtre les résultats en fonction de ce rôle.
     *
     * @param null $array_options Options pour filtrer les résultats.
     *
     * @return array Les membres Crestic correspondant aux critères spécifiés.
     */
    public function findAllMembresCrestic($array_options = null): array
    {
        return $this->findAllMembresCresticBuilder($array_options)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne un QueryBuilder pour récupérer tous les membres Crestic
     * associés à un responsable spécifique, en excluant les anciens membres.
     *
     * @param object $responsable L'objet responsable dont l'ID est utilisé pour filtrer les membres.
     *
     * @return QueryBuilder Le QueryBuilder pour récupérer les membres Crestic associés au responsable spécifié.
     */
    public function findAllMembresCresticResponsableBuilder(object $responsable): QueryBuilder
    {
        return $this->createQueryBuilder('a','a.id')
            ->where('a.id = ?1 and a.ancienMembresCrestic = false')
            ->orderBy('a.nom', 'ASC')
            ->setParameter(1, $responsable->getId())
        ;
    }

    /**
     * Retourne tous les membres Crestic associés à un responsable spécifique, en excluant les anciens membres.
     *
     * @param object $responsable L'objet responsable dont l'ID est utilisé pour filtrer les membres.
     *
     * @return array Les membres Crestic associés au responsable spécifié.
     */
    public function findAllMembresCresticResponsable(object $responsable): array
    {
        return $this->findAllMembresCresticResponsableBuilder($responsable)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne un QueryBuilder pour récupérer tous les membres du conseil de laboratoire,
     * en excluant les anciens membres.
     *
     * @return QueryBuilder Le QueryBuilder pour récupérer les membres actuels du conseil de laboratoire.
     */
    public function findAllConseilLaboratoireBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('a','a.id')
            ->where('a.ancienMembresCrestic = false and a.membreConseilLabo = true')
            ->orderBy('a.nom', 'ASC')
        ;
    }

    /**
     * Retourne tous les membres du conseil de laboratoire, en excluant les anciens membres.
     *
     * @return array Les membres actuels du conseil de laboratoire.
     */
    public function findAllConseilLaboratoire(): array
    {
        return $this->findAllConseilLaboratoireBuilder()
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne un QueryBuilder pour récupérer tous les membres, qu'ils soient anciens ou actuels.
     *
     * @return QueryBuilder Le QueryBuilder pour récupérer tous les membres.
     */
    public function findAllMembresBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('a','a.id')
            ->orderBy('a.nom', 'ASC')
        ;
    }

    /**
     * Retourne tous les membres, qu'ils soient anciens ou actuels.
     *
     * @return array Les membres de l'ensemble.
     */
    public function findAllMembres(): array
    {
        return $this->findAllMembresBuilder()
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne un tableau associatif pour l'utilisation dans un formulaire de sélection,
     * avec des clés et des valeurs représentant les membres.
     *
     * @return array Un tableau associatif utilisable dans un formulaire de sélection.
     */
    public function getArrayOfChoiceSelectMembresCresticAll(): array
    {
        $result = [];

        $array = $this->findAllMembres();
        foreach ($array as $key => $value) {
            $result['membreCrestic_'.$key] = $value;
        }

        return $result;
    }

    /**
     * Retourne tous les membres Crestic ayant un certain statut.
     *
     * @param string $status Le statut des membres à rechercher.
     *
     * @return array Les membres Crestic ayant le statut spécifié.
     */
    public function findAllMembresCresticStatus(string $status): array
    {
        return $this->findBy(['status' => $status, 'ancienMembresCrestic' => false], ['nom' => 'ASC', 'prenom' => 'ASC']);
    }

    /**
     * Retourne tous les anciens membres Crestic.
     *
     * @return array Les anciens membres Crestic.
     */
    public function findAllMembresAncienCrestic(): array
    {
        return $this->findBy(['ancienMembresCrestic' => true], ['nom' => 'ASC', 'prenom' => 'ASC']);
    }


    /**
     * Retourne tous les anciens membres Crestic ayant un certain statut.
     *
     * @param string $status Le statut des anciens membres à rechercher.
     *
     * @return array Les anciens membres Crestic ayant le statut spécifié.
     */
    public function findAllMembresAncienCresticStatus(string $status): array
    {
        return $this->findBy(['status' => $status, 'ancienMembresCrestic' => true] , ['nom' => 'ASC', 'prenom' => 'ASC']);
    }

    /**
     * Retourne un QueryBuilder pour récupérer tous les membres de l'équipe responsable.
     *
     * @return QueryBuilder Le QueryBuilder pour récupérer les membres de l'équipe responsable.
     */
    public function getEquipeResponsableBuilder(): QueryBuilder
    {
        return  $this->createQueryBuilder('a')
            ->orderBy('a.nom', 'ASC')
        ;
    }

    /**
     * Retourne tous les membres de l'équipe responsable.
     *
     * @return array Les membres de l'équipe responsable.
     */
    public function getEquipeResponsable(): array
    {
        return  $this->getEquipeResponsableBuilder()
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne un QueryBuilder pour récupérer tous les membres Crestic dont le nom contient une certaine chaîne.
     *
     * @param string $nom La chaîne à rechercher dans les noms des membres.
     *
     * @return QueryBuilder Le QueryBuilder pour récupérer les membres correspondant au nom spécifié.
     */
    public function findAllNomMembreCresticBuilder(string $nom): QueryBuilder
    {
        return $this->createQueryBuilder('a','a.id')
            ->select('a')
            ->where('a.ancienMembresCrestic = 0 AND a.nom LIKE :nom')
            ->setParameter('nom',"%".$nom."%")
        ;
    }

    /**
     * Retourne tous les membres Crestic dont le nom contient une certaine chaîne.
     *
     * @param string $nom La chaîne à rechercher dans les noms des membres.
     *
     * @return array Les membres Crestic correspondant au nom spécifié.
     */
    public function findAllNomMembreCrestic(string $nom): array
    {
        return $this->findAllNomMembreCresticBuilder($nom)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne un QueryBuilder pour rechercher des membres Crestic actuels en fonction des données fournies.
     *
     * @param array $data Les données de recherche.
     *
     * @return QueryBuilder Le QueryBuilder pour rechercher les membres Crestic actuels.
     */
    public function findMembreCresticBuilder(array $data): QueryBuilder
    {
        $qb = $this->createQueryBuilder('a','a.id');
        $qb->orderBy('a.nom', 'ASC');
        $qb->where('a.ancienMembresCrestic = 0');

        $nom = array_key_exists('nom', $data) ? $data['nom'] : '';
        if ($nom != '')
        {
            $qb->andWhere('a.nom LIKE :nom');
            $qb->setParameter('nom',"%".$nom."%");
        }

        $prenom = array_key_exists('prenom', $data) ? $data['prenom'] : '';
        if ($prenom != '')
        {
            $qb->andWhere('a.prenom LIKE :prenom');
            $qb->setParameter('prenom',"%".$prenom."%");
        }

        $keywords = array_key_exists('keywords', $data) ? $data['keywords'] : '';
        if ($keywords != '')
        {
            $qb->andWhere('a.url LIKE :keywords OR a.cv LIKE :keywords OR a.themes LIKE :keywords OR a.pointsForts LIKE :keywords OR a.responsabilitesScientifiques LIKE :keywords OR a.responsabilitesAdministratives LIKE :keywords OR a.valorisation LIKE :keywords  OR a.enseignements LIKE :keywords OR a.responsabiliteFonction LIKE :keywords');
            $qb->setParameter('keywords',"%".$keywords."%");
        }

        return $this->extracted($data, $qb);
    }

    /**
     * Retourne tous les membres Crestic actuels en fonction des données fournies.
     *
     * @param array $data Les données de recherche.
     *
     * @return array Les membres Crestic actuels correspondant aux critères spécifiés.
     */
    public function findMembreCrestic(array $data): array
    {
        return $this->findMembreCresticBuilder($data)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne un QueryBuilder pour rechercher des anciens membres Crestic en fonction des données fournies.
     *
     * @param array $data Les données de recherche.
     *
     * @return QueryBuilder Le QueryBuilder pour rechercher les anciens membres Crestic.
     */
    public function findMembreAncienBuilder(array $data): QueryBuilder
    {
        $qb = $this->createQueryBuilder('a','a.id');
        $qb->orderBy('a.nom', 'ASC');
        $qb->where('a.ancienMembresCrestic = 1');

        return $this->extracted($data, $qb);
    }

    /**
     * Retourne tous les anciens membres Crestic en fonction des données fournies.
     *
     * @param array $data Les données de recherche.
     *
     * @return array Les anciens membres Crestic correspondant aux critères spécifiés.
     */
    public function findMembreAncien(array $data): array
    {
        return $this->findMembreAncienBuilder($data)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Retourne un QueryBuilder pour rechercher des membres en fonction des données fournies.
     *
     * @param array $data Les données de recherche.
     * @param QueryBuilder $qb Le QueryBuilder initial.
     *
     * @return QueryBuilder Le QueryBuilder modifié en fonction des données de recherche.
     */
    public function extracted(array $data, QueryBuilder $qb): QueryBuilder
    {
        $nom = $data['nom'];
        if ($nom != '') {
            $qb->andWhere('a.nom LIKE :nom');
            $qb->setParameter('nom', "%" . $nom . "%");
        }

        $prenom = $data['prenom'];
        if ($prenom != '') {
            $qb->andWhere('a.prenom LIKE :prenom');
            $qb->setParameter('prenom', "%" . $prenom . "%");
        }

        $keywords = $data['keywords'];
        if ($keywords != '') {
            $qb->andWhere('a.url LIKE :keywords OR a.cv LIKE :keywords OR a.themes LIKE :keywords OR a.pointsForts LIKE :keywords OR a.responsabilitesScientifiques LIKE :keywords OR a.responsabilitesAdministratives LIKE :keywords OR a.valorisation LIKE :keywords  OR a.enseignements LIKE :keywords OR a.responsabiliteFonction LIKE :keywords');
            $qb->setParameter('keywords', "%" . $keywords . "%");
        }

        return $qb;
    }

    public function findMembreAncien ($data)
    {
        return $this->findMembreAncienBuilder($data)->getQuery()->getResult();
    }

}
