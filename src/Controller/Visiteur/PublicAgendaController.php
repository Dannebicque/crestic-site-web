<?php

namespace App\Controller\Visiteur;

use App\Entity\Agenda;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/agenda')]
class PublicAgendaController extends AbstractController
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {
    }

    #[Route(path: '/', name: 'public_agenda')]
    public function index(): Response
    {
        $evt = $this->managerRegistry->getRepository(Agenda::class)->findAll();

        return $this->render('publicAgenda/index.html.twig', [
            'evenements' => $evt
        ]);
    }

    #[Route(path: '/{id}', name: 'public_agenda_show')]
    public function show(Agenda $id): Response
    {
        return $this->render('publicAgenda/show.html.twig', [
            'agenda' => $id
        ]);
    }
}
