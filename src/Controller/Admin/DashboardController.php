<?php

namespace App\Controller\Admin;

use App\Entity\Actualites;
use App\Entity\Agenda;
use App\Entity\CategorieDocument;
use App\Entity\CategorieProjet;
use App\Entity\Cms;
use App\Entity\Configuration;
use App\Entity\Departements;
use App\Entity\Documents;
use App\Entity\DocumentsInternes;
use App\Entity\Emplois;
use App\Entity\Equipes;
use App\Entity\EquipesHasMembres;
use App\Entity\EquipesHasSliders;
use App\Entity\Financeurs;
use App\Entity\MembresCrestic;
use App\Entity\Organigramme;
use App\Entity\Partenaires;
use App\Entity\Plateformes;
use App\Entity\Projets;
use App\Entity\ProjetsHasEquipes;
use App\Entity\ProjetsHasMembres;
use App\Entity\ProjetsHasSliders;
use App\Entity\Sites;
use App\Entity\Slider;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route(path: '/administration', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // the name visible to end users
            ->setTitle('CReSTIC')

            ;
    }

    public function configureMenuItems(): iterable
    {
        //todo:lien vers profil, vers equipes et vers projets

        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Actualités');
        yield MenuItem::linkToCrud('Actualités', 'fa fa-tags', Actualites::class)->setPermission('ROLE_ADMINISTRATEUR');
        yield MenuItem::linkToCrud('Agenda', 'fa fa-file-text', Agenda::class)->setPermission('ROLE_ADMINISTRATEUR');
        yield MenuItem::linkToCrud('Emplois', 'fa fa-file-text', Emplois::class);
        yield MenuItem::linkToCrud('Documents', 'fa fa-file-text', Documents::class);

        yield MenuItem::section('Intranet');
        yield MenuItem::linkToCrud('Documents Internes', 'fa fa-file-text', DocumentsInternes::class);
        yield MenuItem::linkToCrud('Catégories des documents', 'fa fa-file-text', CategorieDocument::class);


        yield MenuItem::section('Publications')->setPermission('ROLE_ADMINISTRATEUR');
        yield MenuItem::linkToRoute('Statistiques de publications','fa fa-tags', 'admin_statistiques_publications')->setPermission('ROLE_ADMINISTRATEUR');

        yield MenuItem::section('Projets');
        yield MenuItem::linkToCrud('Catégories de projet', 'fa fa-tags', CategorieProjet::class)->setPermission('ROLE_ADMINISTRATEUR');
        yield MenuItem::linkToCrud('Projets', 'fa fa-file-text', Projets::class);
        yield MenuItem::linkToCrud('Slider Projets', 'fa fa-file-text', ProjetsHasSliders::class);
        yield MenuItem::linkToCrud('Projets / Membres', 'fa fa-file-text', ProjetsHasMembres::class);
        yield MenuItem::linkToCrud('Projets / Equipes', 'fa fa-file-text', ProjetsHasEquipes::class);
        yield MenuItem::linkToCrud('Financeurs', 'fa fa-file-text', Financeurs::class);
        yield MenuItem::linkToCrud('Partenaires', 'fa fa-file-text', Partenaires::class);

        yield MenuItem::section('Equipes');
        yield MenuItem::linkToCrud('Equipes', 'fa fa-file-text', Equipes::class);
        yield MenuItem::linkToCrud('Membres / Equipes', 'fa fa-file-text', EquipesHasMembres::class);
        yield MenuItem::linkToCrud('Slider Equipes', 'fa fa-file-text', EquipesHasSliders::class);

        yield MenuItem::section('Structure du laboratoire');
        yield MenuItem::linkToCrud('Départements', 'fa fa-tags', Departements::class)->setPermission('ROLE_ADMINISTRATEUR');
        yield MenuItem::linkToCrud('Membres', 'fa fa-file-text', MembresCrestic::class)->setPermission('ROLE_ADMINISTRATEUR');
        yield MenuItem::linkToCrud('plateformes', 'fa fa-file-text', Plateformes::class)->setPermission('ROLE_ADMINISTRATEUR');

        yield MenuItem::section('Site web')->setPermission('ROLE_ADMINISTRATEUR');
        yield MenuItem::linkToCrud('Pages', 'fa fa-file-text', Cms::class)->setPermission('ROLE_ADMINISTRATEUR');
        yield MenuItem::linkToCrud('Sites', 'fa fa-file-text', Sites::class)->setPermission('ROLE_ADMINISTRATEUR');
        yield MenuItem::linkToCrud('Slides', 'fa fa-file-text', Slider::class);
        yield MenuItem::linkToCrud('Organigramme', 'fa fa-file-text', Organigramme::class)->setPermission('ROLE_ADMINISTRATEUR');
        yield MenuItem::linkToCrud('Configuration', 'fa fa-file-text', Configuration::class)->setPermission('ROLE_ADMINISTRATEUR');
    }
}
