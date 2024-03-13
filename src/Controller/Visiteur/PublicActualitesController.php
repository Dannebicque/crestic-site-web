<?php

namespace App\Controller\Visiteur;

use App\Entity\Actualites;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/actualites')]
class PublicActualitesController extends AbstractController
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {
    }

    #[Route(path: '/', name: 'public_actualites')]
    public function index(): Response
    {
        $actualites = $this->managerRegistry->getRepository(Actualites::class)->findBy(['interne' => false],
            ['dateactu' => 'DESC']);

        return $this->render('publicActualites/index.html.twig', ['actualites' => $actualites]);
    }

    #[Route(path: '/interne', name: 'public_actualites_interne')]
    public function interne(): Response
    {
        $actualites = $this->managerRegistry->getRepository(Actualites::class)->findBy(['interne' => true],
            ['dateactu' => 'DESC']);

        return $this->render('publicActualites/interne.html.twig', ['actualites' => $actualites]);
    }

    /**
     * @param $slug
     */
    #[Route(path: '/{slug}', name: 'public_actualites_show')]
    public function show($slug): Response
    {
        $actualite = $this->managerRegistry->getRepository(Actualites::class)->findOneBy(['slug' => $slug]);

        return $this->render('publicActualites/show.html.twig', [
            'actualite' => $actualite
        ]);
    }

}
