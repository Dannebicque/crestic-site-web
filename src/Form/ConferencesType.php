<?php

namespace App\Form;

use Genemu\Bundle\FormBundle\Form\JQuery\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConferencesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomConference', TextType::class, ['label'              => 'nomConference', 'translation_domain' => 'messages', 'required'           => true])
            ->add('sigleConference', TextType::class, ['label'              => 'sigleConference', 'translation_domain' => 'messages', 'required'           => true])
            ->add('internationale', ChoiceType::class, ['choices'            => ['Oui' => true, 'Non' => false], 'label'              => 'internationale', 'translation_domain' => 'messages', 'expanded'           => true, 'required'           => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Conferences']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_conferences';
    }


}
