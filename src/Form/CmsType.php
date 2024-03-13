<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CmsType extends AbstractType
{
    private $titreen;
    private $texteen;
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre', TextType::class, ['label'    => 'Titre', 'required' => true])
            ->add('texte', TextareaType::class, ['label'    => 'Texte', 'required' => false, 'attr'     => ['class' => 'tinyMCE']])
        ->add('titreen', TextType::class, ['label'    => 'Titre (Anglais)', 'required' => false, 'data'     =>  $this->titreen, 'mapped'   => false])
        ->add('texteen', TextareaType::class, ['label'    => 'Texte (Anglais)', 'required' => false, 'mapped'   => false, 'data'     =>  $this->texteen, 'attr'     => ['class' => 'tinyMCE']]);
//            ->add('slug', TextType::class, array(
//                'label'              => 'Slug (ne pas modifier)',
//                'required'           => false,
//            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => \App\Entity\Cms::class, 'titreen' => null, 'texteen' => null]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_cms';
    }


}
