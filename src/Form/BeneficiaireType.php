<?php

namespace App\Form;

use App\Entity\Beneficiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class BeneficiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de famille *',
                'attr' => ['class' => 'input'], 
                ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom *',
                'attr' => ['class' => 'input'],
            ])
            ->add('datenaissance', DateType::class, [
                'attr' => ['class' => 'input'],
                'widget' => 'single_text',
                'format' => 'dd/mm/yyyy',
                'html5' => false,
                'label' => 'Date de naissance (dd/mm/yyyy)'
            ])
            ->add('paysnaissance', CountryType::class, [
                'attr' => ['class' => 'input'], 
                'choice_translation_locale' => null,
                'preferred_choices'=>['FR', 'SN'],
                'label' => 'Pays de naissance'
                
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone *',
                'attr' => ['class' => 'input'], 
                ])
            ->add('teldomicile', TextType::class, [
                'label' => 'Tél domicile',
                'attr' => ['class' => 'input'], 
                'required'=>false, 
                'empty_data' => '0000000000'
                ])
            ->add('email', TextType::class, [
                'label' => 'Email *',
                'attr' => ['class' => 'input'], 
                ])
           // ->add('souscripteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Beneficiaire::class,
        ]);
    }
}
