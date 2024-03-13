<?php

namespace App\Controller\Admin;

use App\Entity\Equipes;
use App\Entity\EquipesHasMembres;
use App\Entity\MembresCrestic;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class EquipesHasMembresCrudController extends AbstractCrudController
{
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined()
            ->setPageTitle('index', 'Equipes - Membres')
            ->setPageTitle('new', 'Ajouter un membre à une équipe')
            ->setPageTitle('edit', 'Modifier un membre d\'une équipe')
            ;
    }

    public static function getEntityFqcn(): string
    {
        return EquipesHasMembres::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('membreCrestic'))
            ->add(ChoiceFilter::new('equipe')->setFilterFqcn(Equipes::class))
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('membreCrestic', 'Membre')
                ->setCrudController( MembresCresticCrudController::class),
            AssociationField::new('equipe', 'Equipe')
                ->setCrudController( EquipesCrudController::class)
        ];
    }
}
