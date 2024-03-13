<?php

namespace App\Controller\Admin;

use App\Entity\PlateformesHasSliders;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlateformesHasSlidersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PlateformesHasSliders::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
            ;
    }
}
