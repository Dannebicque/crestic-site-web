<?php

namespace App\Controller\Admin;

use App\Entity\Documents;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class DocumentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Documents::class;
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
            TextField::new('titre', 'Titre'),
            ImageField::new('pdf', 'Fichier')
                ->setUploadDir('/public/uploads/documents/')
                ->setBasePath('/uploads/documents/')->hideOnIndex(),
            TextareaField::new('description', 'Description')
        ];
    }
}
