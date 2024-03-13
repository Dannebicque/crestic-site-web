<?php

namespace App\Controller\Admin;

use App\Entity\Plateformes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class PlateformesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Plateformes::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Plateformes')
            ->setPageTitle('new', 'Ajouter une plateforme')
            ->setPageTitle('edit', 'Modifier une plateforme')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom'),
            TextEditorField::new('description', 'Description')->setFormType(CKEditorType::class)->hideOnIndex()->setNumOfRows(20),
            TextField::new('localisation', 'Localisation (bâtiment, site)'),
            ImageField::new('image', 'Illustration')->setUploadDir('/public/uploads/plateformes/')->hideOnIndex(),
            UrlField::new('url', 'Site Web')

        ];
    }

}
