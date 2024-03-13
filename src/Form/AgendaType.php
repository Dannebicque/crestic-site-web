<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgendaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre', TextType::class, ['required' => true, 'label' => 'Titre'])
            ->add('description', TextareaType::class, ['attr' => ['class' => 'tinyMCE']])
            ->add('datedebut', DateType::class, ['required' => true, 'label' => 'Date de début'])
            ->add('heuredebut', TimeType::class, ['required' => true, 'label' => 'Heure de début'])
            ->add('datefin', DateType::class, ['label' => 'Date de fin', 'required' => false])
            ->add('heurefin', TimeType::class, ['label' => 'Heure de fin', 'required' => false])
            ->add('lieu', TextType::class, ['required' => true, 'label' => 'Lieu'])/*->add('type', ChoiceType::class, array('choices' => array('Séminaires du laboratoire' => 'Séminaires du laboratoire',
                                                                      'Conférences' => 'Conférences',
                                                                      'Soutenances Thèses/HDR' => 'Soutenances Thèses/HDR',
                                                                      'Réunions' => 'Réunions',
                                                                      'Autres évenements' => 'Autres évenements'
            ), 'required' => true))*/
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => \App\Entity\Agenda::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_agenda';
    }


}
