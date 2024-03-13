<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FinanceursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, [])
            ->add('url', TextType::class, [])
            ->add('internationale', ChoiceType::class,
                ['choices' => ['Oui' => true, 'Non' => false], 'expanded' => true])
            ->add('typeFinanceur', ChoiceType::class,
                ['choices' => ['Académique' => 'A', 'Industriel' => 'I'], 'expanded' => true])
            ->add('imageFile', FileType::class, ['label' => 'Logo']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => \App\Entity\Financeurs::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_partenaires';
    }


}
