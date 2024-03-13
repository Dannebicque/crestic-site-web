<?php

namespace App\Controller\Admin;

use App\Entity\Equipes;
use App\Entity\MembresCrestic;
use App\Entity\Projets;
use App\Entity\ProjetsHasEquipes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class ProjetsHasEquipesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProjetsHasEquipes::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('equipe', 'Equipe'))
            ->add(ChoiceFilter::new('projet', 'Projet')->setFilterFqcn(Projets::class))

            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('equipe', 'Equipe')->setCrudController( Equipes::class),
            AssociationField::new('projet', 'Projet')->setCrudController( Projets::class)
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
            ;
    }
}
