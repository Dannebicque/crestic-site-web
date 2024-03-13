<?php

namespace App\Controller\Admin;

use App\Entity\Partenaires;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PartenairesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Partenaires::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the names of the Doctrine entity properties where the search is made on
            // (by default it looks for in all properties)
            ->setDefaultSort(['nom' => 'ASC'])
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Partenaires')
            ->setPageTitle('new', 'Ajouter un partenaire')
            ->setPageTitle('edit', 'Modifier un partenaire')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom'),
            TextField::new('url', 'Site web'),
            BooleanField::new('internationale', 'Partenaire international ?'),
            ImageField::new('image', 'Image/Logo')->setUploadDir('/public/uploads/partenaires/')->hideOnIndex(),
        ];
    }
}
