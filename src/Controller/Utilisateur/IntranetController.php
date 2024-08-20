<?php

namespace App\Controller\Utilisateur;

use App\Repository\CategorieDocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route(path: '/documents/liste', name: 'liste_documents')]
    public function listeDocuments(
        Request $request,
        CategorieDocumentRepository $categorieDocumentRepository
    ): Response
    {
        $idCategorie = $request->query->get('categorie');
        $categorie = $categorieDocumentRepository->find($idCategorie);


        return $this->render('utilisateur/intranet/_documents.html.twig', [
            'categorie' => $categorie,
        ]);
    }
}
