<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditeursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, ['label'    => 'Nom', 'required' => true])
            ->add('lien', TextType::class, ['label'    => 'Site Web', 'required' => false])
            ->add('ville', TextType::class, ['label'    => 'Ville', 'required' => false])
            ->add('pays', EntityType::class, ['class'        => \App\Entity\Pays::class, 'choice_label' => 'nomFr', 'label'        => 'Pays', 'required'     => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Editeurs']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_editeurs';
    }


}
