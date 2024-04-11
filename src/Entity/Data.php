<?php
/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 03/07/2017
 * Time: 22:14
 */

namespace App\Entity;

/**
 * Class Configuration
 * @package DA\KernelBundle\Entity
 */
class Data
{


    final public const TAB_STATUS = [
        ['code' => 'PR', 'libelle' => 'Professeurs'],
        ['code' => 'MCF', 'libelle' => 'Maîtres de Conférences'],
        ['code' => 'PU-PH', 'libelle' => 'Prof. Praticien Hospitalier'],
        ['code' => 'MCU-PH', 'libelle' => 'MCF Praticien Hospitalier'],
        ['code' => 'Assoc', 'libelle' => 'Chercheurs Associés'],
        ['code' => 'ING', 'libelle' => 'Ingénieurs'],
        ['code' => 'ING-R', 'libelle' => 'Ingénieurs de recherche'],
        ['code' => 'TECH', 'libelle' => 'Techniciens'],
        ['code' => 'PAST', 'libelle' => 'PAST/MAST'],
        ['code' => 'P-DOC', 'libelle' => 'Post-Doctorants'],
        ['code' => 'ATER', 'libelle' => 'ATER'],
        ['code' => 'ING-C', 'libelle' => 'Ingénieurs contractuels'],
        ['code' => 'DOC', 'libelle' => 'Doctorants URCA'],
        ['code' => 'DOCH', 'libelle' => 'Doctorants Hors URCA'],
        ['code' => 'ADM', 'libelle' => 'Personnels administratifs'],
    ];

    final public const LISTE = [
        'ec' => ['PR', 'MCF', 'PU-PH', 'MCU-PH','ING'],
        'adm' => ['ADM', 'TECH'],
        'doc' => ['DOC', 'DOCH'],
        'assoc' => ['Assoc'],
        'past' => ['PAST'],
        'pdoc' => ['P-DOC'],
        'ater' => ['ATER'],
        'ing' => ['ING-C'],

    ];

    final public const TAB_STATUS_FORM = [
        '' => '',
        'Professeurs' => 'PR',
        'Maîtres de Conférences' => 'MCF',
        'Prof. Praticien Hospitalier' => 'PU-PH',
        'MCF Praticien Hospitalier' => 'MCU-PH',
        'Chercheurs Associés' => 'Assoc',
        'Ingénieurs' => 'ING',
        'Ingénieurs de recherche' => 'ING-R',
        'Techniciens' => 'TECH',
        'PAST/MAST' => 'PAST',
        'Post-Doctorants' => 'P-DOC',
        'ATER' => 'ATER',
        'Ingénieurs contractuels' => 'ING-C',
        'Doctorants URCA' => 'DOC',
        'Doctorants Hors URCA' => 'DOCH',
        'Personnels administratifs' => 'ADM',
    ];

    final public const TAB_ORGANIGRAMME = [
        'Directeur' => 'Directeur',
        'Directeur Adjoint' => 'Directeur Adjoint',
        'Secrétaire' => 'Secrétaire',
        'Technicien' => 'Technicien'
    ];

    final public const TAB_CATEGORIES_PROJETS = [
        'International' => 'international',
        'Européen' => 'europeen',
        'PIA' => 'pia',
        'ANR' => 'anr',
        'CNRS' => 'cnrs',
        'CIFRE' => 'cifre',
        'Contrats industriels' => 'contratsindustriels',
        'Region' => 'region',
        'Fonds privés' => 'prives',
        'Autres' => 'autres',
    ];
    const TAB_ROLES_FORM = [
        'Utilisateur' => 'ROLE_UTILISATEUR',
        'Administrateur' => 'ROLE_ADMINISTRATEUR',
        'ROLE_RESPONSABLE' => 'ROLE_RESPONSABLE',
    ];
}
