<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActualitesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, ['label'    => 'Titre', 'required' => true])
            ->add('titreen', TextType::class, ['label'    => 'Title', 'required' => false, 'mapped'   => false])
            ->add('interne', ChoiceType::class, ['label'    => 'Type', 'choices' => ['Vie du laboratoire' => true, 'Actualités' => false], 'expanded' => true, 'multiple' => false])
            ->add('dateactu', DateType::class, ['label'    => 'Date', 'widget' => 'single_text'])
            ->add('message', TextareaType::class, ['label'    => 'Texte', 'required' => true, 'attr'     => ['class' => 'tinyMCE']])
            ->add('messageen', TextareaType::class, ['label'    => 'Text', 'required' => false, 'attr'     => ['class' => 'tinyMCE'], 'mapped'   => false])
            ->add('imageFile', FileType::class, ['label'    => 'Illustration', 'required' => false]);
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => \App\Entity\Actualites::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_actualites';
    }


}
