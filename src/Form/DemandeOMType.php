<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeOMType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('membreCrestic', EntityType::class, ['label'        => 'Membre du CReSTIC', 'class'        => \App\Entity\MembresCrestic::class, 'empty_data'   => 'Choisir un responsable', 'choice_label' => 'display', 'attr'         => ['class' => 'select2']])
            ->add('dateDepart', DateType::class, ['label' => 'Date de départ'])
            ->add('heureDepart', TimeType::class, ['label' => 'Heure de départ'])
            ->add('dateRetour', DateType::class, ['label' => 'Date de retour'])
            ->add('heureRetour', TimeType::class, ['label' => 'Heure de retour'])
            ->add('objet', TextType::class, ['label' => 'Objet de la mission'])
            ->add('ville', TextType::class, ['label' => 'Ville'])
            ->add('pays', EntityType::class, ['class' => \App\Entity\Pays::class, 'choice_label' => 'nomFr'])
            ->add('commentaire', TextType::class, ['required' => false, 'label' => 'Commentaire sur la demande'])
            ->add('omSansFrais', ChoiceType::class, ['label'    => 'OM sans frais', 'choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true])
            ->add('ligneBudget', TextType::class, ['required' => false]);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\DemandeOM']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_demandeom';
    }


}
