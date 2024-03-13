<?php

namespace App\Controller\Utilisateur;

use App\Repository\CategorieDocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'intranet', name: 'utilisateur_intranet_')]
class IntranetController extends AbstractController
{

    #[Route(path: '/documents', name: 'documents')]

    public function documents(
        CategorieDocumentRepository $categorieDocumentRepository
    ): Response
    {
        return $this->render('utilisateur/intranet/documents.html.twig', [
            'categories' => $categorieDocumentRepository->findAll(),
        ]);
    }
}
