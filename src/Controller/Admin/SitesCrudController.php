<?php

namespace App\Controller\Admin;

use App\Entity\CategorieProjet;
use App\Entity\Cms;
use App\Entity\MembresCrestic;
use App\Entity\Sites;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SitesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sites::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the names of the Doctrine entity properties where the search is made on
            // (by default it looks for in all properties)
            ->setDefaultSort(['titre' => 'ASC'])
            ->showEntityActionsInlined()
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Site'),
            TextField::new('titre', 'Titre'),
            BooleanField::new('principale', 'Site principal ?'),

            FormField::addPanel('Contact local'),
            AssociationField::new('membreCrestic', 'Contact local')->setCrudController(MembresCrestic::class),
            TextField::new('mail', 'Email'),
            TextField::new('tel', 'Téléphone')->hideOnIndex(),
            TextField::new('fax', 'Fax')->hideOnIndex(),
            FormField::addPanel('Adresse'),
            TextField::new('adresse', 'Adresse')->hideOnIndex(),
            TextField::new('cp','Code postal')->hideOnIndex(),
            TextField::new('ville', 'Ville'),
            FormField::addPanel('Accéder au site'),
            TextareaField::new('map', 'Lien Google Map')->hideOnIndex(),
            AssociationField::new('cms', 'Page descriptive')->setCrudController(Cms::class),


        ];
    }


}
