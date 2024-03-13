<?php

namespace App\Form;

use App\Entity\Data;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class MembresCresticType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['required' => true, 'label' => 'Nom'])
            ->add('prenom', TextType::class, ['required' => true, 'label' => 'Prénom'])
            ->add('cnu', ChoiceType::class,
                ['choices' => ['61' => '61', '27' => '27'], 'required' => false, 'label' => 'CNU', 'attr'         => ['class' => 'select2']])
            ->add('departementMembre', EntityType::class, ['class' => \App\Entity\Departements::class, 'choice_label' => 'nom', 'expanded' => true])

            ->add('status', ChoiceType::class, ['choices'  => Data::TAB_STATUS_FORM, 'required' => true, 'label'    => 'Statut', 'attr'         => ['class' => 'select2']])
            ->add('site', ChoiceType::class, ['choices'  => ['Reims'                => 'Reims', 'Troyes'               => 'Troyes', 'Châlons en Champagne' => 'Châlons en Champagne', 'Charleville-Mézières' => 'Charleville-Mézières'], 'required' => false, 'label'    => 'Site d\'affectation', 'attr'         => ['class' => 'select2']])
            ->add('batiment', TextType::class, ['required' => false, 'label' => 'Bâtiment'])
            ->add('etage', TextType::class, ['required' => false, 'label' => 'Etage'])
            ->add('bureau', TextType::class, ['required' => false, 'label' => 'Bureau'])
            ->add('datenomination', DateType::class, ['required' => false, 'label' => 'Date de nomination'])
            ->add('email', TextType::class, ['required' => true, 'label' => 'Email'])
            ->add('username', TextType::class, ['required' => true, 'label' => 'Login (Urca si possible)'])
            ->add('membreConseilLabo', ChoiceType::class, ['required' => true, 'label'    => 'Membre du Conseil de laboratoire', 'choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true, 'attr'         => ['class' => 'select2']])
            ->add('role', ChoiceType::class, ['choices'  => ['Membre du CReSTIC'                       => 'ROLE_UTILISATEUR', 'Administrateur du site'                  => 'ROLE_ADMIN', 'Responsable d\'équipe/Projet/Plateforme' => 'ROLE_RESPONSABLE'], 'required' => true, 'label'    => 'Autorisations', 'attr'         => ['class' => 'select2']]);
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
