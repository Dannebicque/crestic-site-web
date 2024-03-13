<?php

namespace App\Controller\Admin;

use App\Entity\Equipes;
use App\Entity\ProjetsHasSliders;
use App\Repository\EquipesRepository;
use App\Repository\ProjetsRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProjetsHasSlidersCrudController extends AbstractCrudController
{
    public function __construct(
        Private ProjetsRepository $projetsRepository
    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return ProjetsHasSliders::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
            ;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $result = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if (!$this->isGranted('ROLE_ADMINISTRATEUR')) {
            # Getting data User wise
            $result->where('entity.responsable = :user')
                ->setParameter('user', $this->getUser()?->getId());
        }

        return $result;

    }


    public function configureFields(string $pageName): iterable
    {

        if (!$this->isGranted('ROLE_ADMINISTRATEUR')) {
            return [
                AssociationField::new('projet', 'Projet')
                    ->setQueryBuilder($this->projetsRepository->createQueryBuilder('eq')
                        ->where('eq.responsable = :user')
                        ->setParameter('user', $this->getUser()?->getId())
                        ->orderBy('eq.nom', 'ASC')),
                AssociationField::new('slider', 'Image de slider')->renderAsEmbeddedForm( SliderCrudController::class),
            ];
        }

        return [
            AssociationField::new('projet', 'Projet')->setCrudController( Equipes::class),
            AssociationField::new('slider', 'Image de slider')->renderAsEmbeddedForm( SliderCrudController::class),

        ];
    }
}
