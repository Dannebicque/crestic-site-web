<?php

namespace App\Form;

use App\Entity\Data;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class MembresCresticCompletType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['required' => true, 'label' => 'Nom'])
            ->add('prenom', TextType::class, ['required' => true, 'label' => 'Prénom'])
            ->add('email', TextType::class, ['required' => true, 'label' => 'Email URCA'])
            ->add('username', TextType::class, ['required' => true, 'label' => 'Login URCA'])
            ->add('slug', TextType::class, ['required' => false, 'label' => 'Slug (pour l\'URL du profil)'])
            ->add('idhal', TextType::class, ['required' => false, 'label' => 'Id-Hal'])
            ->add('imageFile', FileType::class, ['required' => false, 'label' => 'Photo'])
            ->add('dateNaissance', DateType::class, ['required' => false, 'widget'   => 'single_text', 'format'   => 'dd/MM/yyyy', 'attr'     => ['placeholder' => 'dd/mm/aaaa'], 'label'    => 'Date de naissance'])
            ->add('adresse', TextType::class, ['label' => 'Adresse professionnelle', 'required' => false])
            ->add('site', ChoiceType::class, ['choices'  => ['Châlons en Champagne' => 'Châlons en Champagne', 'Charleville-Mézières' => 'Charleville-Mézières', 'Reims'                => 'Reims', 'Troyes'               => 'Troyes'], 'label'    => 'Site du CReSTIC', 'required' => false])
            ->add('batiment', TextType::class, ['label' => 'Bâtiment', 'required' => false])
            ->add('bureau', TextType::class, ['label' => 'Bureau', 'required' => false])
            ->add('tel', TextType::class, ['label' => 'Téléphone Pro.', 'required' => false])
            ->add('telPortable', TextType::class, ['label' => 'télpéhone Port.', 'required' => false])
            ->add('disciplinehceres', TextType::class, ['required' => false, 'label' => 'Discipline HCERES'])
            ->add('status', ChoiceType::class, ['choices'  => Data::TAB_STATUS_FORM, 'required' => true, 'label'    => 'Statut'])
            ->add('cnu', ChoiceType::class,
                ['choices' => ['61' => '61', '27' => '27'], 'required' => false, 'label' => 'CNU'])
            ->add('departementMembre', EntityType::class, ['class' => \App\Entity\Departements::class, 'choice_label' => 'nom', 'expanded' => true, 'required' => false])
            ->add('hdr', ChoiceType::class, ['label'    => 'Titulaire de l\'hdr', 'choices'  => ['Oui' => true, 'Non' => false], 'required' => false])
            ->add('datenomination', DateType::class, ['required' => false, 'label' => 'Date de nomination'])
            ->add('corpsgrade', TextType::class, ['label' => 'Corps/Grade', 'required' => false])
            ->add('adressePerso', TextType::class, ['label' => 'Adresse personnelle', 'required' => false])
            ->add('emailPerso', TextType::class, ['label' => 'Email personnelle', 'required' => false])
            ->add('url', TextType::class, ['label' => 'Site Web', 'required' => false])
            ->add('cv', TextareaType::class, ['attr' => ['class' => 'tinyMCE'], 'required' => false])
            ->add('themes', TextareaType::class, ['attr' => ['class' => 'tinyMCE'], 'required' => false])
            ->add('responsabilitesScientifiques', TextareaType::class,
                ['attr' => ['class' => 'tinyMCE'], 'required' => false])
            ->add('responsabilitesAdministratives', TextareaType::class,
                ['attr' => ['class' => 'tinyMCE'], 'required' => false])
            ->add('evaluation', TextareaType::class, ['attr' => ['class' => 'tinyMCE'], 'required' => false])
            ->add('editorial', TextareaType::class, ['attr' => ['class' => 'tinyMCE'], 'required' => false])
            ->add('valorisation', TextareaType::class,
                ['attr' => ['class' => 'tinyMCE'], 'required' => false])
            ->add('vulgarisation', TextareaType::class,
                ['attr' => ['class' => 'tinyMCE'], 'required' => false])
            ->add('international', TextareaType::class,
                ['attr' => ['class' => 'tinyMCE'], 'required' => false])
            ->add('enseignements', TextareaType::class,
                ['attr' => ['class' => 'tinyMCE'], 'required' => false])
            ->add('responsabiliteFonction', TextareaType::class,
                ['attr' => ['class' => 'tinyMCE'], 'required' => false])
            ->add('ancienMembresCrestic', ChoiceType::class, ['label'    => 'Ancien membre du CReSTIC', 'choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true])
            ->add('membreAssocie', ChoiceType::class, ['label'    => 'Membre associé', 'choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true])
            ->add('membreConseilLabo', ChoiceType::class, ['label'    => 'Membre du conseil de laboratoire', 'choices'  => ['Oui' => true, 'Non' => false], 'expanded' => true])
            ->add('role', ChoiceType::class, ['choices'  => ['Membre du CReSTIC'                       => 'ROLE_UTILISATEUR', 'Administrateur du site'                  => 'ROLE_ADMIN', 'Responsable d\'équipe/Projet/Plateforme' => 'ROLE_RESPONSABLE'], 'required' => true, 'label'    => 'Autorisations']);;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => \App\Entity\MembresCrestic::class]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'App_membrescrestic';
    }


}
