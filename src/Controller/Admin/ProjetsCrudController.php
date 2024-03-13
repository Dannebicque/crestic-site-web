<?php

namespace App\Controller\Admin;

use App\Entity\CategorieProjet;
use App\Entity\Data;
use App\Entity\MembresCrestic;
use App\Entity\Projets;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ProjetsCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Projets::class;
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
            // the names of the Doctrine entity properties where the search is made on
            // (by default it looks for in all properties)
            ->setDefaultSort(['titre' => 'ASC', 'dateDebut' => 'DESC'])
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ->showEntityActionsInlined()
            ->setPageTitle('index', 'Projets')
            ->setPageTitle('new', 'Ajouter un projet')
            ->setPageTitle('edit', 'Modifier un projet')

            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre', 'Nom du projet'),
            DateField::new('dateDebut', 'Début du projet'),
            DateField::new('dateFin', 'Fin du projet'),
            TextField::new('financement'),
            ChoiceField::new('typeprojet', 'Type de projet')->setChoices(Data::TAB_CATEGORIES_PROJETS),
            AssociationField::new('categorie','Catégorie de projet')->setCrudController(CategorieProjet::class),
            TextField::new('porteurprojet', 'Porteur du projet'),
            AssociationField::new('responsable', 'Responsable pour le CReSTIC')->setCrudController(MembresCrestic::class)->hideOnIndex(),
            ImageField::new('image', 'Illustration du projet')->setUploadDir('/public/uploads/projets/')->hideOnIndex(),
            TextEditorField::new('description', 'Description')->setFormType(CKEditorType::class)->hideOnIndex()->setNumOfRows(20),


        ];
    }
}
