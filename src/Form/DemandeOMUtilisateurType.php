<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeOMUtilisateurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateDepart')
            ->add('heureDepart')
            ->add('dateRetour')
            ->add('heureRetour')
            ->add('objet', TextType::class, ['label' => 'Objet de la mission'])
            ->add('ville', TextType::class, ['label' => 'Ville'])
            ->add('commentaire', TextType::class, ['required' => false])
            ->add('omSansFrais', ChoiceType::class, ['label'    => 'OM Sans Frais', 'choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true])
            ->add('ligneBudget', TextType::class, ['required' => true, 'label' => 'Projet ou convention'])
            ->add('pays', EntityType::class, ['class' => \App\Entity\Pays::class, 'choice_label' => 'nomFr']);
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
