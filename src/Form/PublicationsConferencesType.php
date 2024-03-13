<?php

namespace App\Form;

use App\Entity\PublicationsConferences;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationsConferencesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('serie', TextType::class, ['label' => 'Série', 'required' => false])
            ->add('volume', TextType::class, ['label' => 'Volume', 'required' => false])
            ->add('comiteLecture', ChoiceType::class, ['choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true, 'label'    => 'Conférence avec comité de lecture'])
            ->add('acte', ChoiceType::class, ['choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true, 'label'    => 'Conférence avec actes'])
            ->add('invite', ChoiceType::class, ['choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true, 'label'    => 'Session invitée'])
            ->add('poster', ChoiceType::class, ['choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true, 'label'    => 'Session Poster'])
            ->add('isbn', TextType::class, ['label' => 'ISBN', 'required' => false])
            ->add('conference', EntityType::class, ['class'        => 'App\Entity\Conferences', 'choice_label' => 'conferenceForm', 'label'        => 'Conférence'])
            ->add('ville', TextType::class, ['label'              => 'ville', 'translation_domain' => 'messages', 'required'           => false])
            ->add('dateDebut', DateType::class, ['years' => range(1980, date('Y')+3)])
            ->add('dateFin', DateType::class, ['years' => range(1980, date('Y')+3)])
            ->add('tauxSelection', TextType::class, ['label'              => 'tauxSelection', 'translation_domain' => 'messages', 'required'           => false])
            ->add('urlConference', TextType::class, ['label'              => 'urlConference', 'translation_domain' => 'messages', 'required'           => false])
            ->add('pays', EntityType::class, ['class'              => \App\Entity\Pays::class, 'choice_label'       => 'nomFr', 'label'              => 'pays', 'translation_domain' => 'messages', 'required'           => true])
            ->add('editeur', EntityType::class, ['class'              => 'App\Entity\Editeurs', 'choice_label'       => 'nom', 'label'              => 'editeur', 'translation_domain' => 'messages', 'required'           => false]);

        $builder->add('bar', PublicationsType::class, ['data_class' => PublicationsConferences::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\PublicationsConferences']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_publicationsconferences';
    }


}
