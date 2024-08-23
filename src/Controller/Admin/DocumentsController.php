<?php

namespace App\Controller\Admin;

use App\Entity\CategorieDocument;
use App\Entity\DocumentsInternes;
use App\Repository\CategorieDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Dropzone\Form\DropzoneType;

class DocumentsController extends AbstractController
{
    #[Route('/administration/documents', name: 'admin_documents')]
    public function index(): Response
    {
        return $this->render('admin/documents.html.twig', [
        ]);
    }

    #[Route('/administration/documents/categories', name: 'admin_documents_categories')]
    public function categories(
        Request                     $request,
        EntityManagerInterface      $em,
        CategorieDocumentRepository $categorieDocumentRepository
    ): Response
    {
        if ($request->isMethod('POST')) {
            $categorie = new CategorieDocument();
            $cat = $request->request->get('parent', null);
            if ($cat) {
                $cat = $categorieDocumentRepository->find($cat);
                $categorie->setCategorieParent($cat);
            }
            $categorie->setLibelle($request->request->get('categorie'));
            $em->persist($categorie);
            $em->flush();
        }


        return $this->render('admin/_categories.html.twig', [
            'categories' => $categorieDocumentRepository->findAll(),
        ]);
    }

    #[Route('/administration/documents/categorie', name: 'admin_show_categorie')]
    public function categorie(
        Request                     $request,
        CategorieDocumentRepository $categorieDocumentRepository
    ): Response
    {
        $idCategorie = $request->query->get('categorie');
        $categorie = $categorieDocumentRepository->find($idCategorie);
        if ($categorie === null) {
            return new Response('Catégorie non trouvée', 404);
        }

        $form = $this->createFormBuilder()
            ->add('photo', DropzoneType::class, [
                'label' => 'Ajouter un document',
                'attr' => [
                    'data-categorie' => $categorie->getId(),
                    'placeholder' => 'Ajouter un document (glisser-déposer ou cliquer pour sélectionner)',
                ],
            ])
            ->getForm();

        return $this->render('admin/_show_categorie.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/administration/documents/categorie/{categorie}/liste', name: 'admin_documents_liste')]
    public function listeDocumentsCategorie(
        CategorieDocument $categorie,
    ): Response
    {
        return $this->render('admin/_liste_documents_categorie.html.twig', [
            'categorie' => $categorie,
            'documents' => $categorie->getDocumentsInternes(),
        ]);
    }

    #[Route('/administration/documents/categorie/{id}/delete', name: 'admin_categorie_document_delete', methods: ['DELETE'])]
    public function suppressionCategorie(): Response
    {

    }

    #[Route('/administration/documents/{id}/delete', name: 'admin_document_delete', methods: ['DELETE'])]
    public function deleteDocument(
        KernelInterface        $kernel,
        EntityManagerInterface $em,
        DocumentsInternes $document
    ): Response
    {
        $chemin = $kernel->getProjectDir() . '/public/uploads/documentsInternes/' . $document->getFichier();
        if (file_exists($chemin)) {
            unlink($chemin);
        }

        $em->remove($document);
        $em->flush();

        return $this->json(true);

    }

    #[Route('/administration/documents/categorie/{categorie}/add', name: 'admin_documents_add')]
    public function addDocumentCategorie(
        EntityManagerInterface $em,
        KernelInterface        $kernel,
        Request                $request,
        CategorieDocument      $categorie,
    ): Response
    {
        //récupérer le document dans le request
        // gérer l'upload
        // ajouter les éléments en BDD

        $fichier = $request->files->get('document');
        if ($fichier === null) {
            return new JsonResponse(['error' => 'Aucun fichier reçu'], 400);
        }

        $size = $fichier->getSize();
        $nomFichier = $fichier->getClientOriginalName();

        $fichier->move($kernel->getProjectDir() . '/public/uploads/documentsInternes/', $nomFichier);

        $document = new DocumentsInternes();
        $document->setFichier($nomFichier);
        $document->setSize($size);
        $document->setCategorie($categorie);

        $em->persist($document);
        $em->flush();


        return $this->json(true);
    }
}
