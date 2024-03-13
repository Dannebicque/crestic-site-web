<?php

namespace App\Controller\Admin;

use App\Entity\CategorieProjet;
use App\Entity\Cms;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategorieProjetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategorieProjet::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['parent' => 'ASC','libelle' => 'ASC'])
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Catégories de projets')
            ->setPageTitle('new', 'Ajouter une catégorie de projet')
            ->setPageTitle('edit', 'Modifier une catégorie de projet')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('parent', 'Catégorie parent')->setCrudController(CategorieProjet::class)->setHelp('Laisser vide, si catégorie principale')->setRequired(false),
            IntegerField::new('ordre', 'Ordre dans la catégorie'),
            TextField::new('libelle', 'Libellé'),
            TextField::new('libelle_en', 'Libelle anglais'),


        ];
    }

}
