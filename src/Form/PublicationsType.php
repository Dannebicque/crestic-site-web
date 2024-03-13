<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre', TextType::class, ['label' => 'Titre'])
            ->add('resume', TextareaType::class, ['label' => 'Résumé', 'required' => false])
            ->add('keywords', TextType::class, ['label' => 'Mots clés', 'required' => false])
            ->add('pdfFile', FileType::class, ['label' => 'PDF', 'required' => false])
            ->add('pdfVisible', ChoiceType::class,
                ['choices' => ['Oui' => true, 'Non' => false], 'expanded' => true, 'label' => 'PDF visible'])
            ->add('doi', TextType::class, ['label' => 'DOI', 'required' => false])
            ->add('url', TextType::class, ['label' => 'URL', 'required' => false])
            ->add('commentaire', TextareaType::class, ['label' => 'Commentaire libre', 'required' => false])
            ->add('pageDebut', TextType::class, ['label' => 'Page de début', 'required' => false])
            ->add('pageFin', TextType::class, ['label' => 'Page de fin', 'required' => false])
            ->add('moisPublication', ChoiceType::class, ['label'    => 'Mois de publication', 'required' => false, 'choices'  => [''          => 0, 'Janvier'   => 1, 'Février'   => 2, 'Mars'      => 3, 'Avril'     => 4, 'Mai'       => 5, 'Juin'      => 6, 'Juillet'   => 7, 'Août'      => 8, 'Septembre' => 9, 'Octobre'   => 10, 'Novembre'  => 11, 'Décembre'  => 12]])
            ->add('anneePublication', TextType::class, ['label' => 'Année de publication'])
            ->add('publicationInternationale', ChoiceType::class, ['expanded' => true, 'label'    => 'Type de publication', 'data'     => true, 'choices'  => ['Publication Internationale' => true, 'Publication Nationale' => false]])
            ->add('publicationPourLeCrestic', ChoiceType::class, ['expanded' => true, 'label'    => 'Publication associée au CReSTIC', 'data'     => true, 'choices'  => ['Publication associée au CReSTIC' => true, 'Publication hors CReSTIC' => false]]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['inherit_data' => true]);
    }

}
