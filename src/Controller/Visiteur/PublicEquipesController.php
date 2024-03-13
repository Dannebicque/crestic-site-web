<?php

namespace App\Controller\Visiteur;

use App\Repository\EquipesHasMembresRepository;
use App\Repository\EquipesHasSlidersRepository;
use App\Repository\EquipesRepository;
use App\Repository\ProjetsHasEquipesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'equipe')]
class PublicEquipesController extends AbstractController
{
    #[Route(path: '/{slug}', name: 'public_equipes_profil')]
    public function profil(
        EquipesRepository $equipesRepository,
        EquipesHasMembresRepository $equipesHasMembresRepository,
        EquipesHasSlidersRepository $equipesHasSlidersRepository,
        ProjetsHasEquipesRepository $projetsHasEquipesRepository,
        $slug
    ): Response {
        $equipe = $equipesRepository->findOneBy(['slug' => $slug]);
        if ($equipe) {
            return $this->render('publicEquipes/profil.html.twig', [
                'equipe' => $equipe,
                'membres' => $equipesHasMembresRepository->findAllMembresFromEquipe($equipe->getId()),
                'sliders' => $equipesHasSlidersRepository->findAllSlidersFromEquipe($equipe->getId()),
                'projets' => $projetsHasEquipesRepository->findByEquipe($equipe->getId())
            ]);
        }

        throw new NotFoundHttpException("Equipe non trouvée");
    }
}
