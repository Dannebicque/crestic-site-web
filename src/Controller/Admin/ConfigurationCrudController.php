<?php

namespace App\Controller\Admin;

use App\Entity\Configuration;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ConfigurationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Configuration::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Configuration')
            ->setPageTitle('edit', 'Modifier une configuration')
            ->setPageTitle('new', 'Ajouter une configuration')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('cle', 'Clé (ne pas modifier)'),
            TextField::new('value', 'Valeur')
        ];
    }

}
