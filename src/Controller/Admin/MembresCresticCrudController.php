<?php

namespace App\Controller\Admin;

use App\Entity\Data;
use App\Entity\Departements;
use App\Entity\MembresCrestic;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class MembresCresticCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MembresCrestic::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the names of the Doctrine entity properties where the search is made on
            // (by default it looks for in all properties)
            ->setSearchFields(['nom', 'prenom'])
            ->setDefaultSort(['nom' => 'ASC', 'prenom' => 'ASC'])
            ->setPageTitle('index', 'Membres du CReSTIC')
            ->setPageTitle('new', 'Ajouter un membre')
            ->setPageTitle('edit', 'Modifier un membre')
            ->showEntityActionsInlined();
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('status')->setChoices(Data::TAB_STATUS_FORM))
            ->add(BooleanFilter::new('ancienMembresCrestic'))
            ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        $tab = [
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            BooleanField::new('ancienMembresCrestic', 'Ancien membre ?'),
            DateField::new('dateDepart', 'Fin d\'activité au CReSTIC'),
            BooleanField::new('hdr', 'HDR ?'),
            TextField::new('site', 'Site'),
            ChoiceField::new('status', 'Status')->setChoices(Data::TAB_STATUS_FORM),
            ImageField::new('image', 'Photo')->hideOnIndex()->setUploadDir('/public/uploads/membresCrestic/'),
            TextField::new('email', 'Email')->hideOnIndex(),
            TextField::new('username', 'Login URCA')->hideOnIndex(),
            TextField::new('idHal', 'Id hal')->hideOnIndex(),
        ];

        if ($this->isGranted('ROLE_ADMINISTRATEUR')) {
            //gestion des rôles
            $tab[] = ChoiceField::new('roles', 'Rôles')->setChoices(Data::TAB_ROLES_FORM)
                ->allowMultipleChoices()
                ->renderExpanded()
            ;


        }

        return $tab;
    }
}
