<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RevuesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titreRevue', TextType::class, ['label'              => 'Titre de la revue', 'translation_domain' => 'messages', 'required'           => true])
            ->add('sigleRevue', TextType::class, ['label'              => 'Sigle de la revue', 'translation_domain' => 'messages', 'required'           => true])
            ->add('internationale', ChoiceType::class, ['choices'            => ['Oui' => true, 'Non' => false], 'label'              => 'Revue internationale', 'translation_domain' => 'messages', 'required'           => true, 'expanded'           => true])
            ->add('impactFactor', TextType::class, ['label'              => 'Impact Factor', 'translation_domain' => 'messages', 'required'           => false])
            ->add('classification', TextType::class, ['label'              => 'Classification', 'translation_domain' => 'messages', 'required'           => false])
            ->add('url', TextType::class, ['label'              => 'Site web', 'translation_domain' => 'messages', 'required'           => false])
            ->add('editeur', EntityType::class, ['class'              => 'App\Entity\Editeurs', 'choice_label'       => 'nom', 'label'              => 'Editeur', 'translation_domain' => 'messages', 'required'           => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Revues']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_revues';
    }


}
