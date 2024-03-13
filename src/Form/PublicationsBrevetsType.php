<?php

namespace App\Form;

use App\Entity\PublicationsBrevets;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationsBrevetsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateDepot', DateType::class, ['label' => 'Date de dépôt'])
            ->add('numeroDepot', TextType::class, ['label' => 'Numéro de dépôt', 'required' => false])
            ->add('dateDelivrance', DateType::class, ['label' => 'Date de délivrance', 'required' => false])
            ->add('numeroDelivrance', TextType::class, ['label' => 'Numéro de délivrance', 'required' => false])
            ->add('secteur', TextareaType::class, ['label' => 'Secteur', 'required' => false])
            ->add('typeBrevet', ChoiceType::class, ['label'    => 'Type de dépôt', 'choices'  => ['Brevet' => 'brevet', 'Lettre d\'intention' => 'lettre'], 'expanded' => true, 'required' => false])
            ->add('pays', EntityType::class, ['class'        => \App\Entity\Pays::class, 'choice_label' => 'nomFR', 'label'        => 'Pays', 'required'     => false]);

        $builder->add('bar', PublicationsType::class, ['data_class' => PublicationsBrevets::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\PublicationsBrevets']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_publicationsbrevets';
    }


}
