<?php

namespace App\Controller\Admin;

use App\Entity\Data;
use App\Entity\MembresCrestic;
use App\Entity\Organigramme;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class OrganigrammeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Organigramme::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('membreCrestic', 'Membre')->setCrudController(MembresCrestic::class),
            ChoiceField::new('responsabiliteFonction', 'Fonction')->setChoices(Data::TAB_ORGANIGRAMME),
            IntegerField::new('ordre', 'Ordre'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Organigramme')
            ->setPageTitle('new', 'Ajouter un membre à l\'organigramme')
            ->setPageTitle('edit', 'Modifier un membre de l\'organigramme')
            ;
    }

}
