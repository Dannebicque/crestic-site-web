<?php

namespace App\Controller\Visiteur;

use App\Repository\DepartementsRepository;
use App\Repository\EquipesHasDepartementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/departement')]
class PublicDepartementsController extends AbstractController
{
    #[Route(path: '/', name: 'public_departements')]
    public function index(): Response
    {
        return $this->render('publicDepartements/index.html.twig');
    }

    /**
     * @param $slug
     */
    #[Route(path: '/{slug}', name: 'public_departement')]
    public function voir(
        DepartementsRepository $departementsRepository,
        EquipesHasDepartementsRepository $equipesHasDepartementsRepository,
        $slug
    ): Response {
        $departement = $departementsRepository->findOneBy(['slug' => $slug]);
        if ($departement !== null) {
            $equipes = $equipesHasDepartementsRepository->findAllEquipesFromDepartement($departement->getId());

            return $this->render('publicDepartements/voir.html.twig', [
                'departement' => $departement,
                'equipes' => $equipes
            ]);
        }

        throw new NotFoundHttpException("Département non trouvé");
    }

}
