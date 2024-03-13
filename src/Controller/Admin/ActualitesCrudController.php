<?php

namespace App\Controller\Admin;

use App\Entity\Actualites;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ActualitesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actualites::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the names of the Doctrine entity properties where the search is made on
            // (by default it looks for in all properties)
            ->setSearchFields(['titre'])
            ->setDefaultSort(['dateactu' => 'DESC', 'titre' => 'ASC'])
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Actualités')
            ->setPageTitle('new', 'Ajouter une actualité')
            ->setPageTitle('edit', 'Modifier une actualité')
            ;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre', 'Titre'),
            DateField::new('dateactu', 'Date'),
            ImageField::new('image', 'Image')
                ->setUploadDir('/public/uploads/actualites/')
            ->setBasePath('/uploads/actualites/'),
            BooleanField::new('interne', 'Actualité interne ?')->setHelp('Cocher si le message est destiné à la communication interne du CReSTIC'),
            TextField::new('slug')->hideOnForm(),
            TextEditorField::new('message', 'Message')
                ->hideOnIndex()
                ->setNumOfRows(20)
                ->setTrixEditorConfig([])
        ];
    }
}
