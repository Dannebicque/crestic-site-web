<?php

namespace App\Controller\Admin;

use App\Entity\Agenda;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class AgendaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Agenda::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['datedebut' => 'DESC', 'heuredebut' => 'ASC'])
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Agenda')
            ->setPageTitle('new', 'Ajouter un événement')
            ->setPageTitle('edit', 'Modifier un événement')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre', 'Titre'),
            DateField::new('datedebut', 'Date de début'),
            TimeField::new('heuredebut', 'Heure de début'),
            DateField::new('datefin', 'Date de fin'),
            TimeField::new('heurefin', 'Heure de fin'),
            TextField::new('lieu', 'lieu'),
            TextEditorField::new('description', 'Description')->hideOnIndex()->setNumOfRows(20)

        ];
    }
}
