<?php

namespace App\Controller\Admin;

use App\Entity\Emplois;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EmploisCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Emplois::class;
    }
}
