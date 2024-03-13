<?php

namespace App\Form;

use App\Entity\PublicationsOuvrages;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationsOuvragesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeOuvrage', TextareaType::class, ['label' => 'Type d\'ouvrage', 'required' => false])
            ->add('serie', TextType::class, ['label' => 'Série', 'required' => false])
            ->add('vulgarisation', ChoiceType::class, ['choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true, 'label'    => 'Ouvrage de vulgarisation', 'required' => false])
            ->add('monographie', ChoiceType::class, ['choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true, 'label'    => 'Monographie', 'required' => false])
            ->add('collectif', ChoiceType::class, ['choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true, 'label'    => 'Ouvrage Collectif', 'required' => false])
            ->add('isbn', TextType::class, ['label' => 'ISBN', 'required' => false])
            ->add('editeur', EntityType::class, ['class'        => 'App\Entity\Editeurs', 'choice_label' => 'nom', 'label'        => 'Editeur', 'required'     => false]);

        $builder->add('bar', PublicationsType::class, ['data_class' => PublicationsOuvrages::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\PublicationsOuvrages']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_publicationsouvrages';
    }


}

