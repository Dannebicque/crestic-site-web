<?php

namespace App\Controller\Admin;

use App\Classes\Hal;
use App\Repository\DepartementsRepository;
use App\Repository\EquipesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiquesPublicationsController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route(path: '/administration/publications/statistiques', name: 'admin_statistiques_publications')]
    public function index(
        DepartementsRepository $departementsRepository,
        EquipesRepository $equipesRepository,
        Hal $hal): Response
    {
        $departements = $departementsRepository->findAll();

        foreach ($departements as $departement) {
            $hal->calculStatistiques($departement);
        }

        $equipes = $equipesRepository->findAllEquipesActives();

        return $this->render('admin/statistiques_publications/index.html.twig', [
            'departements' => $departements,
            'equipes' => $equipes,
            'statistiquesDepartement' => $hal->getStatsDepartement(),
            'statistiquesEquipes' => $hal->getStatsEquipe(),
            'statistiquesMembre' => $hal->getStatsMembre(),
        ]);
    }
}

