<?php

namespace App\Controller\Admin;

use App\Entity\CategorieDocument;
use App\Entity\DocumentsInternes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DocumentsInternesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DocumentsInternes::class;
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
            TextField::new('titre'),
            TextEditorField::new('description'),
            ImageField::new('fichier')->hideOnIndex()->setUploadDir('/public/uploads/documentsInternes/'),
            AssociationField::new('categorie','Catégorie du document')->setCrudController(CategorieDocument::class),
        ];
    }

}
