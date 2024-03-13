<?php

namespace App\Controller\Admin;

use App\Entity\CategorieProjet;
use App\Entity\Financeurs;
use App\Entity\MembresCrestic;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FinanceursCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Financeurs::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the names of the Doctrine entity properties where the search is made on
            // (by default it looks for in all properties)
            ->setDefaultSort(['nom' => 'ASC'])
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Financeurs')
            ->setPageTitle('new', 'Ajouter un financeur')
            ->setPageTitle('edit', 'Modifier un financeur')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom'),
            TextField::new('url', 'Site Web'),
            BooleanField::new('internationale', 'Financeur international ?'),
            ImageField::new('image', 'Image/logo')->setUploadDir('/public/uploads/financeurs/')->hideOnIndex(),
        ];
    }
}
