<?php

namespace App\Controller\Admin;

use App\Entity\Equipes;
use App\Entity\MembresCrestic;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class EquipesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Equipes::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $result = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        if (!$this->isGranted('ROLE_ADMINISTRATEUR')) {
            # Getting data User wise
            $result->where('entity.responsable = :user')
                ->setParameter('user', $this->getUser()->getId());
        }

        return $result;

    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(['titre'])
            ->setDefaultSort(['active' => 'DESC', 'nom' => 'ASC'])
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Equipes')
            ->setPageTitle('new', 'Ajouter une équipe')
            ->setPageTitle('edit', 'Modifier une équipe')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom court'),
            TextField::new('nomlong', 'Nom complet'),
            TextField::new('slug', 'Slug (URL)'),
            BooleanField::new('active', 'Equipe active'),
            AssociationField::new('responsable', 'Responsable de l\'équipe')->setCrudController( MembresCrestic::class),
            TextEditorField::new('themeRecherche', 'Thème de recherche')->setFormType(CKEditorType::class)->hideOnIndex()->setNumOfRows(20),
            ImageField::new('image', 'Image d\'illustration')->hideOnIndex()->setUploadDir('/public/uploads/equipes/')


        ];
    }
}
