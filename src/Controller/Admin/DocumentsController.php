<?php

namespace App\Controller\Admin;

use App\Entity\CategorieDocument;
use App\Repository\CategorieDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Dropzone\Form\DropzoneType;

class DocumentsController extends AbstractController
{
    #[Route('/administration/documents', name: 'admin_documents')]
    public function index(
    ): Response
    {
        return $this->render('admin/documents.html.twig', [
        ]);
    }

    #[Route('/administration/documents/categories', name: 'admin_documents_categories')]
    public function categories(
        Request $request,
        EntityManagerInterface $em,
        CategorieDocumentRepository $categorieDocumentRepository
    ): Response
    {
        if ($request->isMethod('POST')) {
            $categorie = new CategorieDocument();
            $categorie->setLibelle($request->request->get('categorie'));
            $em->persist($categorie);
            $em->flush();
        }


        return $this->render('admin/_categories.html.twig', [
            'categories' => $categorieDocumentRepository->findAll(),
        ]);
    }

    #[Route('/administration/documents/liste', name: 'admin_documents_liste')]
    public function liste(
        Request $request,
        CategorieDocumentRepository $categorieDocumentRepository
    ): Response
    {
        $categorie = $request->query->get('categorie');
        $categorie = $categorieDocumentRepository->find($categorie);
        $documents = $categorie->getDocumentsInternes();

        $form = $this->createFormBuilder()
            ->add('photo', DropzoneType::class, [
                'label' => 'Ajouter un document',
                'attr' => [
                    'placeholder' => 'Ajouter un document (glisser-déposer ou cliquer pour sélectionner)',
                ],
            ])
            ->getForm();

        return $this->render('admin/_liste_documents.html.twig', [
            'documents' => $documents,
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }
}
