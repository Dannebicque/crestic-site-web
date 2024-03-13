<?php

namespace App\Form;

use App\Entity\PublicationsChapitres;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationsChapitresType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titreOuvrage', TextType::class, ['label' => 'Titre de l\'ouvrage'])
            ->add('typeOuvrage', TextareaType::class, ['label' => 'Type d\'ouvrage', 'required' => false])
            ->add('serie', TextType::class, ['label' => 'Série', 'required' => false])
            ->add('numero', TextType::class, ['label' => 'Numéro de chapitre', 'required' => false])
            ->add('isbn', TextType::class, ['label' => 'ISBN', 'required' => false])
            ->add('redacteurChef', TextType::class, ['label' => 'Rédacteur en chef', 'required' => false])
            ->add('vulgarisation', ChoiceType::class, ['choices' => ['Oui' => true, 'Non' => false], 'expanded' => true, 'label' => 'Chapitre de vulgarisation'])
            ->add('editeur', EntityType::class,
                ['class' => 'App\Entity\Editeurs', 'choice_label' => 'nom', 'label' => 'Editeur']);

        $builder->add('bar', PublicationsType::class, ['data_class' => PublicationsChapitres::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\PublicationsChapitres']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_publicationschapitres';
    }


}
