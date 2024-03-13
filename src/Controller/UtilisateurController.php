<?php

namespace App\Controller;

use App\Entity\Activites;
use App\Entity\MembresCrestic;
use App\Repository\ActivitesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/espace-utilisateur')]
class UtilisateurController extends AbstractController
{
    #[Route(path: '/', name: 'homepage_utilisateur')]
    public function index(
        ActivitesRepository $activitesRepository
    ): Response
    {
        $user = $this->getUser();
        $activites = $activitesRepository->findLastActiviteMembre($user->getId());

        return $this->render('utilisateur/index.html.twig', [
            'user' => $user,
            'activites' => $activites
        ]);
    }
}
