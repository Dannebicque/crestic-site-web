<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmploisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre', TextType::class, ['label' => 'Titre de l\'offre'])
            ->add('resume', TextType::class, ['label' => 'Résumé de l\'offre'])
            ->add('description', TextareaType::class,
                ['label' => 'Description de l\'offre', 'attr' => ['class' => 'tinyMCE']])
            ->add('debut', DateType::class, ['label' => 'Début souhaité'])
            ->add('duree', TextType::class, ['label' => 'Durée du contrat'])
            ->add('pdfFile', FileType::class, ['label' => 'Fichier PDF', 'required' => false])
            ->add('contact', EntityType::class, ['class'        => \App\Entity\MembresCrestic::class, 'empty_data'   => 'Choisir un responsable', 'choice_label' => 'display', 'attr'         => ['class' => 'select2']])
            ->add('projet', EntityType::class, ['required'     => false, 'label'        => 'Projet associé', 'class'        => \App\Entity\Projets::class, 'choice_label' => 'titre', 'attr'         => ['class' => 'select2']]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => \App\Entity\Emplois::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_emplois';
    }


}
