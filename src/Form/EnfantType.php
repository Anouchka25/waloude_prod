<?php

namespace App\Form;

use App\Entity\Enfant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EnfantType extends AbstractType
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
                'label' => 'Date de naissance (dd/mm/yyyy)*'
            ])
            /* ->add('lien_affiliation', ChoiceType::class, [
                'choices'  => [
                    'Enfant commun' => 'enfant_commun',
                    'Votre enfant' => 'votre_enfant',
                    'Enfant du conjoint' => 'enfant_conjoint',
                ],
            ]) */
            //->add('souscripteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enfant::class,
        ]);
    }
}
