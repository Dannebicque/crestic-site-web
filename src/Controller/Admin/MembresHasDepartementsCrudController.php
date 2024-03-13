<?php

namespace App\Controller\Admin;

use App\Entity\Departements;
use App\Entity\Equipes;
use App\Entity\MembresCrestic;
use App\Entity\MembresHasDepartements;
use App\Entity\Projets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class MembresHasDepartementsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MembresHasDepartements::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('membre'))
            ->add(ChoiceFilter::new('departement')->setFilterFqcn(Departements::class))
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('membre', 'Membre')->setCrudController( MembresCrestic::class),
            AssociationField::new('departement', 'Département')->setCrudController( Departements::class)
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
