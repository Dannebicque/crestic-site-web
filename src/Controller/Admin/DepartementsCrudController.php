<?php

namespace App\Controller\Admin;

use App\Entity\Departements;
use App\Entity\MembresCrestic;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class DepartementsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Departements::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')

            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom du département'),
            TextField::new('sigle', 'Sigle'),
            AssociationField::new('membreCrestic', 'Responsable')->setCrudController( MembresCrestic::class),
            TextEditorField::new('theme', 'Thème')->setFormType(CKEditorType::class)->hideOnIndex()->setNumOfRows(20)


        ];
    }
}
