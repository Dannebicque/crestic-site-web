<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DepartementsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, ['label' => 'Nom du département'])
            ->add('sigle', TextType::class, ['label' => 'Sigle du département'])
            ->add('theme', TextareaType::class, ['label' => 'Thématiques du départemen t', 'attr'  => ['class' => 'tinyMCE']])
            ->add('membreCrestic', EntityType::class, ['label'        => 'Responsable du département', 'class'        => \App\Entity\MembresCrestic::class, 'empty_data'   => 'Choisir un responsable', 'choice_label' => 'display', 'attr'         => ['class' => 'select2']]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => \App\Entity\Departements::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_departements';
    }


}
