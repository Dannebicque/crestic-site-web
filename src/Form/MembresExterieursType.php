<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembresExterieursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, ['label' => 'Nom', 'required' => true])
            ->add('prenom', TextType::class, ['label' => 'Prénom', 'required' => true])
            ->add('nomLabo', TextType::class, ['label' => 'Laboratoire/Université', 'required' => false])
            ->add('laboUrca', ChoiceType::class, ['label'    => 'Laboratoire URCA', 'choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true])
            ->add('international', ChoiceType::class, ['label'    => 'Co-auteur international', 'choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true])
            ->add('email', TextType::class, ['label' => 'Email', 'required' => false])
            ->add('pays', EntityType::class, ['class'              => \App\Entity\Pays::class, 'choice_label'       => 'nomFr', 'label'              => 'pays', 'translation_domain' => 'messages', 'required'           => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\MembresExterieurs']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_membresexterieurs';
    }


}
