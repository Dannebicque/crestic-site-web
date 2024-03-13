<?php

namespace App\Controller\Visiteur;

use App\Entity\Documents;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/documents')]
class PublicDocumentationController extends AbstractController
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {
    }

    #[Route(path: '/', name: 'public_documentation')]
    public function index(): Response
    {
        $documents = $this->managerRegistry->getRepository(Documents::class)->findAll();

        return $this->render('publicDocumentation/index.html.twig', ['documents' => $documents]);
    }
}
