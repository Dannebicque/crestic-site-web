<?php

namespace App\Form;

use App\Entity\Data;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganigrammeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('responsabiliteFonction', ChoiceType::class,
            ['label' => 'Responsabilité', 'choices' => Data::TAB_ORGANIGRAMME])
            ->add('ordre', ChoiceType::class, ['label'      => 'Ordre dans l\'organigramme', 'choices'    => ['1' => 1, '2' => 2, '3' => 3, '4' => 4], 'empty_data' => 1])
            ->add('membreCrestic', EntityType::class, ['label'        => 'Membre du CReSTIC', 'class'        => \App\Entity\MembresCrestic::class, 'empty_data'   => 'Choisir le membre', 'choice_label' => 'display', 'attr'         => ['class' => 'select2']]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => \App\Entity\Organigramme::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_organigramme';
    }


}
