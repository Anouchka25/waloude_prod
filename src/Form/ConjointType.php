<?php

namespace App\Form;

use App\Entity\Conjoint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class ConjointType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de famille',
                'attr' => ['class' => 'input'], 
                ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['class' => 'input'], 
                ])
            ->add('datenaissance', DateType::class, [
                'widget' => 'single_text',
                'format' => 'dd/mm/yyyy',
                'html5' => false,
                'attr' => ['class' => 'input'],
                'label' => 'Date de naissance (dd/mm/yyyy)'
            ])
            ->add('paysnaissance', CountryType::class, [
                'attr' => ['class' => 'input'],
                'preferred_choices'=>['FR'], 
                'label' => 'Pays de naissance'
                
            ])
            //->add('ville_naissance')
            //->add('profession')
            /* ->add('meme_adresse', CheckboxType::class, [
                'label'    => 'Même adresse',
                //'attr' => ['onclick' => 'afficherAdresse('memeAdresse')']
                 ])

            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['class' => 'memeAdresse'], 
                ])
            ->add('code_postal', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['class' => 'memeAdresse'], 
                ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => ['class' => 'memeAdresse'], 
                ]) */
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone *',
                'attr' => ['class' => 'input'], 
                ])
            ->add('teldomicile', TextType::class, [
                'label' => 'Tél domicile',
                'attr' => ['class' => 'input'], 
                ])
           // ->add('email')
            //->add('souscripteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Conjoint::class,
        ]);
    }
}
