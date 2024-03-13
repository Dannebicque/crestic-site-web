<?php

namespace App\Controller\Admin;

use App\Entity\CategorieDocument;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategorieDocumentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategorieDocument::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('categorieParent', 'Catégorie parent')->setCrudController(CategorieDocument::class)->setHelp('Laisser vide, si catégorie principale')->setRequired(false),
            TextField::new('libelle', 'Libellé'),
        ];
    }
}
