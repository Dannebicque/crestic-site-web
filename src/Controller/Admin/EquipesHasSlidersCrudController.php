<?php

namespace App\Controller\Admin;

use App\Entity\Equipes;
use App\Entity\EquipesHasSliders;
use App\Repository\EquipesRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class EquipesHasSlidersCrudController extends AbstractCrudController
{
    public function __construct(
        Private EquipesRepository $equipesRepository
    )
    {
    }

    public static function getEntityFqcn(): string
    {
        return EquipesHasSliders::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ...
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Equipes - Images du slider des équipes')
            ->setPageTitle('edit', 'Modifier l\'image du slider de l\'équipe')
            ->setPageTitle('new', 'Ajouter une image au slider de l\'équipe')
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
                AssociationField::new('equipe', 'Equipe')
                    ->setQueryBuilder($this->equipesRepository->createQueryBuilder('eq')
                        ->where('eq.responsable = :user')
                        ->setParameter('user', $this->getUser()?->getId())
                        ->orderBy('eq.nom', 'ASC')),
                AssociationField::new('slider', 'Image de slider')->renderAsEmbeddedForm( SliderCrudController::class),
            ];
        }

        return [
            AssociationField::new('equipe', 'Equipe')->setCrudController( Equipes::class),
            AssociationField::new('slider', 'Image de slider')->renderAsEmbeddedForm( SliderCrudController::class),

        ];
    }
}
