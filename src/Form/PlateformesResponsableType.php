<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlateformesResponsableType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class,
                ['label' => 'Description de la plateforme', 'attr' => ['class' => 'tinyMCE']])
            ->add('localisation', TextType::class, ['label' => 'Localisation de la plateforle'])
            ->add('imageFile', FileType::class, ['label' => 'Illustration de la plateforme', 'required' => false])
            ->add('url', TextType::class, ['label' => 'Site web de la plateforme', 'required' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => \App\Entity\Plateformes::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_plateformes';
    }


}
