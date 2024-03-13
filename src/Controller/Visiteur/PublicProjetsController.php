<?php

namespace App\Controller\Visiteur;

use App\Repository\CategorieProjetRepository;
use App\Repository\ProjetsHasFinanceursRepository;
use App\Repository\ProjetsHasMembresRepository;
use App\Repository\ProjetsHasPartenairesRepository;
use App\Repository\ProjetsHasSlidersRepository;
use App\Repository\ProjetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/projets', priority: 2)]
class PublicProjetsController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route(path: '/', name: 'public_projets')]
    public function index(
        ProjetsRepository $projetsRepository,
        CategorieProjetRepository $categorieProjetRepository
    ): Response
    {
        $projets = $projetsRepository->findAll();
        $categoriesprojets = $categorieProjetRepository->findBy([],
            ['ordre' => 'ASC']);

        return $this->render('publicProjets/index.html.twig', [
            'projets' => $projets,
            'categoriesprojets' => $categoriesprojets,
        ]);
    }

    #[Route(path: '/{slug}', name: 'public_projet_profil')]
    public function profil(
        ProjetsRepository $projetsRepository,
        ProjetsHasMembresRepository $projetsHasMembresRepository,
        ProjetsHasPartenairesRepository $projetsHasPartenairesRepository,
        ProjetsHasFinanceursRepository $projetsHasFinanceursRepository,
        ProjetsHasSlidersRepository $projetsHasSlidersRepository,
        string  $slug): Response
    {
        $projet = $projetsRepository->findOneBy(['slug' => $slug]);

        if ($projet) {
            $membres = $projetsHasMembresRepository->findAllMembresFromProjet($projet->getId());
            $partenaires = $projetsHasPartenairesRepository->findAllPartenairesFromProjet($projet->getId());
            $financeurs = $projetsHasFinanceursRepository->findAllFinanceursFromProjet($projet->getId());
            $sliders = $projetsHasSlidersRepository->findAllSliderFromProjet($projet->getId());

            return $this->render('publicProjets/profil.html.twig', [
                'projet' => $projet,
                'membres' => $membres,
                'partenaires' => $partenaires,
                'financeurs' => $financeurs,
                'sliders' => $sliders
            ]);
        }

        throw new NotFoundHttpException("Page not found");
    }

}
