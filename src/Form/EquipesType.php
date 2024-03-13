<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, ['label' => 'Nom cours (sigle) de l\'équipe'])
            ->add('nomlong', TextType::class, ['label' => 'Nom long de l\'équipe'])
            ->add('imageFile', FileType::class, ['label' => 'Illustration de l\'équipe', 'required' => false])
            ->add('responsable', EntityType::class, ['label'        => 'Responsable de l\'équipe', 'class'        => \App\Entity\MembresCrestic::class, 'empty_data'   => 'Choisir un responsable', 'choice_label' => 'display', 'attr'         => ['class' => 'select2']])
            ->add('themeRecherche', TextareaType::class, ['label' => 'Thématiques de recherche', 'attr'  => ['class' => 'tinyMCE']]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => \App\Entity\Equipes::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_equipes';
    }


}
