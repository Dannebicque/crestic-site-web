<?php

namespace App\Controller\Admin;

use App\Entity\MailingList;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MaillingListCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MailingList::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('nomlist'),
            CollectionField::new('MembreCrestic_id','MembreCrestic_id'),
        ];
    }

}
