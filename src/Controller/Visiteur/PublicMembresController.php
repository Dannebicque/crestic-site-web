<?php

namespace App\Controller\Visiteur;

use App\Entity\Data;
use App\Entity\MembresCrestic;
use App\Repository\MembresCresticRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class PublicMembresController extends AbstractController
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {
    }

    #[Route(path: '/membres/', name: 'public_membres')]
    public function index(): Response
    {
        return $this->render('publicMembres/index.html.twig', []);
    }

    /**
     * @param $slug
     */
    #[Route(path: '/{slug}', name: 'public_membres_profil')]
    public function profil($slug): Response
    {
        $user = $this->managerRegistry->getRepository(MembresCrestic::class)->findOneBy(['slug' => $slug]);

        return $this->render('publicMembres/profil.html.twig', ['user' => $user]);
    }

    #[Route(path: '/ajax/trombi', name: 'public_membres_trombi_lettre')]
    public function trombiLoad(Request $request): Response
    {
        $lettre = $request->request->get('lettre');
        if ($lettre !== 'tous') {
            $membres = $this->managerRegistry->getRepository(MembresCrestic::class)->findByLettre($lettre);
        } else {
            $membres = $this->managerRegistry->getRepository(MembresCrestic::class)->findAllMembresCrestic();
        }

        return $this->render('publicMembres/trombi.html.twig', ['affichage' => $lettre, 'membres' => $membres]);
    }

    #[Route(path: '/ajax/annuaire', name: 'public_membres_annuaire_lettre')]
    public function annuaireLoad(Request $request): Response
    {
        $lettre = $request->request->get('lettre');

        if ($lettre !== 'tous') {
            $membres = $this->managerRegistry->getRepository(MembresCrestic::class)->findByLettre($lettre);
        } else {
            $membres = $this->managerRegistry->getRepository(MembresCrestic::class)->findAllMembresCrestic();
        }

        return $this->render('publicMembres/annuaire.html.twig', ['affichage' => $lettre, 'membres' => $membres]);
    }

    #[Route(path: '/ajax/liste', name: 'public_membres_liste')]
    public function listeLoad(): Response
    {
        $membres = $this->managerRegistry->getRepository(MembresCrestic::class)->findAllMembresCrestic();

        return $this->render('publicMembres/liste.html.twig',
            ['membres' => $membres, 'categories' => Data::LISTE]);
    }

    /**
     * @return JsonResponse
     */
    #[Route(path: '/ajax/membre/biblio', name: 'ajax_membre_biblio', options: ['expose' => true])]
    public function getBiblioAuteur(
        MembresCresticRepository $membresCresticRepository,
        Request $request
    ) {
        $tab = [];
        $membresCrestic = $membresCresticRepository->find($request->request->get('membreCrestic'));
        if ($membresCrestic !== null) {
            $tab['idHal'] = $membresCrestic->getIdhal();
            $tab['nom'] = $membresCrestic->getNom();
            $tab['prenom'] = $membresCrestic->getPrenom();

            return new JsonResponse($tab);
        }

        return new JsonResponse(false);
    }
}
