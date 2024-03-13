<?php

namespace App\Controller\Utilisateur;

use App\Form\MembresCresticUtilisateurEnType;
use App\Form\MembresCresticUtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/espace-utilisateur/')]
class MembresCresticController extends AbstractController
{
    #[Route(path: 'edit', name: 'utilisateur_membres_edit')]
    public function edit(
        EntityManagerInterface $entityManager,
        Request $request
    ): RedirectResponse|Response {
        $membresCrestic = $this->getUser();
        $editForm = $this->createForm(MembresCresticUtilisateurType::class, $membresCrestic);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modifications enregistrées');

            return $this->redirectToRoute('utilisateur_membres_edit');
        }

        return $this->render('utilisateur/membres/edit.html.twig',
            ['membresCrestic' => $membresCrestic, 'edit_form' => $editForm]);
    }

    #[Route(path: 'edit/anglais', name: 'utilisateur_membres_edit_en')]
    public function editEn(
        EntityManagerInterface $entityManager,
        Request $request
    ): RedirectResponse|Response {
        $membresCrestic = $this->getUser();
        $editForm = $this->createForm(MembresCresticUtilisateurEnType::class, $membresCrestic);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modifications enregistrées');

            return $this->redirectToRoute('utilisateur_membres_edit_en');
        }

        return $this->render('utilisateur/membres/edit_en.html.twig',
            ['membresCrestic' => $membresCrestic, 'edit_form' => $editForm]);
    }
}
