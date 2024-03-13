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

class MembresCresticUtilisateurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datenomination', DateType::class, ['widget' => 'single_text', 'attr'   => ['placeholder' => 'dd/mm/aaaa', 'class' => 'form-control']])
            ->add('idhal', TextType::class, ['required' => false, 'label' => 'Id-Hal', 'attr' => ['class' => 'form-control']])
            ->add('corpsgrade', TextType::class, ['attr' => ['placeholder' => 'Corps/Grade','class' => 'form-control']])
            ->add('site', TextType::class,
                ['attr' => ['placeholder' => 'Site du CReSTIC','class' => 'form-control'], 'required' => false])
            ->add('batiment', TextType::class, ['attr' => ['placeholder' => 'Bâtiment','class' => 'form-control'], 'required' => false])
            ->add('bureau', TextType::class, ['attr' => ['placeholder' => 'Bureau','class' => 'form-control'], 'required' => false])
            ->add('email', TextType::class, ['attr' => ['placeholder' => 'Email professionnel','class' => 'form-control']])
            ->add('emailPerso', TextType::class,
                ['attr' => ['placeholder' => 'Email Perso','class' => 'form-control'], 'required' => false])
            ->add('adresse', TextType::class,
                ['attr' => ['placeholder' => 'Adresse professionnelle','class' => 'form-control'], 'required' => false])
            ->add('imageFile', FileType::class, ['required' => false])
            ->add('dateNaissance', DateType::class, ['required' => false, 'widget'   => 'single_text', 'attr'     => ['placeholder' => 'dd/mm/aaaa','class' => 'form-control']])
            ->add('adressePerso', TextType::class,
                ['attr' => ['placeholder' => 'Adresse personnelle','class' => 'form-control'], 'required' => false])
            ->add('tel', TextType::class,
                ['attr' => ['placeholder' => 'Téléphone Pro.','class' => 'form-control'], 'required' => false])
            ->add('telPortable', TextType::class,
                ['attr' => ['placeholder' => 'télpéhone Port.','class' => 'form-control'], 'required' => false])
            ->add('url', TextType::class,
                ['attr' => ['placeholder' => 'Votre site web','class' => 'form-control'], 'required' => false])
            ->add('cv', CKEditorType::class, ['required' => false])
            ->add('themes', CKEditorType::class, ['required' => false])
            ->add('responsabilitesScientifiques', CKEditorType::class,
                ['required' => false])
            ->add('responsabilitesAdministratives', CKEditorType::class,
                ['required' => false])
            ->add('valorisation', CKEditorType::class,
                ['required' => false])
            ->add('vulgarisation', CKEditorType::class,
                ['required' => false])
            ->add('international', CKEditorType::class,
                ['required' => false])
            ->add('enseignements', CKEditorType::class,
                ['required' => false])
            ->add('evaluation', CKEditorType::class, ['required' => false])
            ->add('editorial', CKEditorType::class, ['required' => false]);
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
