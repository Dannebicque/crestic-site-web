<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembresCresticUtilisateurEnType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('site', TextType::class,
                ['attr' => ['placeholder' => 'Site du CReSTIC','class' => 'form-control'], 'required' => false])
            ->add('batiment', TextType::class, ['attr' => ['placeholder' => 'Bâtiment','class' => 'form-control'], 'required' => false])
            ->add('bureau', TextType::class, ['attr' => ['placeholder' => 'Bureau','class' => 'form-control'], 'required' => false])

            ->add('cvEn', CKEditorType::class, ['required' => false])
            ->add('themesEn', CKEditorType::class, ['required' => false])
            ->add('responsabilitesScientifiquesEn', CKEditorType::class,
                ['required' => false])
            ->add('responsabilitesAdministrativesEn', CKEditorType::class,
                ['required' => false])
            ->add('valorisationEn', CKEditorType::class,
                ['required' => false])
            ->add('vulgarisationEn', CKEditorType::class,
                ['required' => false])
            ->add('internationalEn', CKEditorType::class,
                ['required' => false])
            ->add('enseignementsEn', CKEditorType::class,
                ['required' => false])
            ->add('evaluationEn', CKEditorType::class, ['required' => false])
            ->add('editorialEn', CKEditorType::class, ['required' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => \App\Entity\MembresCrestic::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_membrescrestic';
    }


}
