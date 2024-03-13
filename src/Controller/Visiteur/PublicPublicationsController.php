<?php

namespace App\Controller\Visiteur;

use App\Entity\Departements;
use App\Entity\Equipes;
use App\Entity\MembresCrestic;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/publications', priority: 2)]
class PublicPublicationsController extends AbstractController
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {
    }

    #[Route(path: '/', name: 'public_publications')]
    public function index(): Response
    {
        $equipes = $this->managerRegistry->getManager()->getRepository(Equipes::class)->findAllEquipesActives();
        $departements = $this->managerRegistry->getManager()->getRepository(Departements::class)->findAll();
        $auteurs = $this->managerRegistry->getRepository(MembresCrestic::class)->findAllMembresCrestic();

        return $this->render('publicPublications/index.html.twig',
            ['equipes' => $equipes, 'auteurs' => $auteurs, 'departements' => $departements]);
    }
}

