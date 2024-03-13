<?php

namespace App\Form;

use App\Entity\Data;
use App\Entity\CategorieProjet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, ['label' => 'Titre du projet'])
            ->add('description', TextareaType::class,
                ['label' => 'Description du projet', 'attr' => ['class' => 'tinyMCE']])
            ->add('porteurprojet', TextType::class, ['label' => 'Porteur du projet'])

            ->add('responsable', EntityType::class, ['label'        => 'Contact du projet sur site', 'class'        => \App\Entity\MembresCrestic::class, 'empty_data'   => 'Choisir le contact du projet sur site', 'choice_label' => 'display', 'attr'         => ['class' => 'select2']])
            ->add('imageFile', FileType::class, ['label' => 'Illustration du projet', 'required' => false])
            ->add('dateDebut', DateType::class, ['label' => 'Date de début du projet', 'years' => range(2004, date('Y')+3)])
            ->add('dateFin', DateType::class, ['label' => 'Date de fin prévue du projet', 'years' => range(2004, date('Y')+6)])
            ->add('financement', TextType::class, ['label' => 'Modes de financement du projet'])
            ->add('identification', TextType::class, ['label' => 'Indentification du projet'])
            ->add('url', TextType::class, ['label' => 'Site Web du projet', 'required' => false])
            ->add('budgetGlobal', TextType::class, ['label' => "Montant du budget global"])
            ->add('video')
            ->add('typeprojet', ChoiceType::class, ['choices' => Data::TAB_CATEGORIES_PROJETS])
            ->add('categorie', EntityType::class, ['class' => CategorieProjet::class, 'choice_label' => 'libelle', 'label' => 'Catégorie de menu'])
            ->add('projetInternational', ChoiceType::class, ['label'    => 'Projet international', 'choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true])
            ->add('projetValorisation', ChoiceType::class, ['label'    => 'Projet de valorisation', 'choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true])
            ->add('projetThese', ChoiceType::class, ['label'    => 'Projet support d\une thèse', 'choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true])
            ->add('projetRi', ChoiceType::class, ['label'    => 'Projet Relations Internationales', 'choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => \App\Entity\Projets::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_projets';
    }


}
