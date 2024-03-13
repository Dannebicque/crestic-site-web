<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipesResponsableType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomlong', TextType::class, ['label' => 'Nom long de l\'équipe'])
            ->add('themeRecherche', TextareaType::class, ['label' => 'Thématiques de recherche', 'attr'  => ['class' => 'tinyMCE']])
            ->add('imageFile', FileType::class, ['label' => 'Illustration de l\'équipe', 'required' => false])
            ->add('video');
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
