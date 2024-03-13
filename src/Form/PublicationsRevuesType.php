<?php

namespace App\Form;

use App\Entity\Publications;
use App\Entity\PublicationsRevues;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationsRevuesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('volume', TextType::class, ['label' => 'Volume', 'required' => false])
            ->add('numero', TextType::class, ['label' => 'Numéro', 'required' => false])
            ->add('comiteLecture', ChoiceType::class, ['choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true, 'label'    => 'Avec Comité de lecture'])
            ->add('vulgarisation', ChoiceType::class, ['choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true, 'label'    => 'Revue de vulgarisation'])
            ->add('editorial', ChoiceType::class, ['choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true, 'label'    => 'Contribution editoriale'])
            ->add('issn', TextType::class, ['label' => 'Numéro ISSN', 'required' => false])
            ->add('specialIssue', TextType::class, ['label' => 'Numéro spécial', 'required' => false])
            ->add('redacteurChef', TextType::class, ['label' => 'Rédacteur en chef', 'required' => false])
            ->add('revue', EntityType::class, ['class'        => 'App\Entity\Revues', 'choice_label' => 'titreRevue', 'label'        => 'Titre de la revue'])
            ->add('editeur', EntityType::class, ['class'        => 'App\Entity\Editeurs', 'choice_label' => 'nom', 'label'        => 'Editeur', 'required'     => false]);

        $builder->add('bar', PublicationsType::class, ['data_class' => PublicationsRevues::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\PublicationsRevues']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_publicationsrevues';
    }


}
