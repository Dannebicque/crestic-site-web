<?php

namespace App\Controller\Admin;

use App\Entity\Cms;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class CmsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cms::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the names of the Doctrine entity properties where the search is made on
            // (by default it looks for in all properties)
            ->setSearchFields(['titre'])
            ->setDefaultSort(['titre' => 'ASC'])
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Pages CMS')
            ->setPageTitle('new', 'Ajouter une page')
            ->setPageTitle('edit', 'Modifier une page')
            ;
    }



    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre', 'Titre de la page'),
            TextField::new('slug', 'Slug'),
            TextEditorField::new('texte', 'Texte')->setFormType(CKEditorType::class)->hideOnIndex()->setNumOfRows(30)
        ];
    }

}
