<?php

namespace App\Form;

use App\Entity\PublicationsTheses;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationsThesesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateSoutenance', DateType::class,
            ['label' => 'Date de soutenance', 'years' => range(1990, date('Y') + 1)])
            ->add('departement', TextType::class, ['label' => 'Laboratoire de recherche', 'required' => false])
            ->add('discipline', TextType::class, ['label' => 'Discipline ou Champs', 'required' => false])
            ->add('abbrevDepartement', TextType::class,
                ['label' => 'Abbréviation du laboratoire', 'required' => false])
            ->add('phdorhdr', ChoiceType::class, ['choices'  => ['Thèse' => 'phd', 'Habilitation' => 'hdr'], 'expanded' => true, 'label'    => 'Thèse ou Habilitation'])
            ->add('universite', TextType::class, ['label' => 'Université'])
            ->add('abbrevUniversite', TextType::class,
                ['label' => 'Abbréviation de l\'université', 'required' => false])
            ->add('ville', TextType::class, ['label' => 'Ville', 'required' => false])
            ->add('pays', EntityType::class, ['class'        => \App\Entity\Pays::class, 'choice_label' => 'nomFR', 'label'        => 'Pays', 'required'     => false]);

        $builder->add('bar', PublicationsType::class, ['data_class' => PublicationsTheses::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\PublicationsTheses']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_publicationstheses';
    }


}
