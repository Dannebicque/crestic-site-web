<?php

namespace App\Controller\Visiteur;

use App\Entity\Plateformes;
use App\Entity\PlateformesHasSliders;
use App\Entity\ProjetsHasPlateformes;
use App\Repository\CmsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/plateformes', priority: 2)]
class PublicPlateformesController extends AbstractController
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {
    }

    #[Route(path: '/', name: 'public_plateformes_index')]
    public function index(CmsRepository $cmsRepository): Response
    {

        return $this->render('publicPlateformes/index.html.twig', [
            'page' => $cmsRepository->findOneBy(['slug' => 'plateforme'])
        ]);
    }

    #[Route(path: '/{slug}', name: 'public_plateformes_profil')]
    public function profil($slug): Response
    {
        $plateforme = $this->managerRegistry->getRepository(Plateformes::class)->findOneBy(['slug' => $slug]);

        if ($plateforme) {
            $sliders = $this->managerRegistry->getRepository(PlateformesHasSliders::class)->findAllSliderFromPlateforme($plateforme->getId());
            $projets = $this->managerRegistry->getRepository(ProjetsHasPlateformes::class)->findAllProjetsFromPlateforme($plateforme->getId());

            return $this->render('publicPlateformes/profil.html.twig',
                ['plateforme' => $plateforme, 'sliders' => $sliders, 'projets' => $projets]);
        }

        throw new NotFoundHttpException("Page not found");

    }

}
