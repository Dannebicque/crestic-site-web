<?php

namespace App\Controller\Visiteur;

use App\Entity\Emplois;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/emplois')]
class PublicEmploisController extends AbstractController
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {
    }

    #[Route(path: '/', name: 'public_emploi')]
    public function index(): Response
    {
        $offres = $this->managerRegistry->getRepository(Emplois::class)->findBy([], ['created' => 'DESC']);

        return $this->render('publicEmplois/index.html.twig', ['offres' => $offres]);
    }

    #[Route(path: '/ajax', name: 'public_emploi_details')]
    public function detail(Request $request): Response
    {
        $offre = $this->managerRegistry->getRepository(Emplois::class)->find($request->request->get('offre'));

        return $this->render('publicEmplois/detail.html.twig', ['offre' => $offre]);
    }

}
