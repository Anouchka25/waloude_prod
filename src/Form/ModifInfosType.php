<?php

namespace App\Form;

use App\Entity\Souscripteur;
use App\Entity\Enfant;
use App\Form\EnfantType;
use App\Entity\Beneficiaire;
use App\Form\BeneficiaireType;
use App\Form\ConjointType;
use App\Form\Conjoint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ModifInfosType extends SouscripteurType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('civilite', ChoiceType::class, [
                'choices'  => [
                    'Madame' => 'Madame',
                    'Mademoiselle' => 'Mademoiselle',
                    'Monsieur' => 'Monsieur',
                ],
                'label' => 'Civilité *',
                'attr' => ['class' => 'input'],
            ])
            //->add('nom', TextType::class)
            ->remove('nom', TextType::class, [
                'label' => 'Nom de famille *',
                'attr' => ['class' => 'input'], 
                ])
            ->remove('prenom', TextType::class, [
                'label' => 'Prénom *',
                'attr' => ['class' => 'input'], 
                ])
            ->remove('nomjeunefille', TextType::class, [
                'label' => 'Nom de de jeune fille',
                'attr' => ['class' => 'input'],
                'required'=>false, 
                'empty_data' => 'Pas de nom de jeune fille' 
                ])
            ->remove('datenaissance', DateType::class, [
                'label' => 'Date de naissance (dd/mm/yyyy)*',
                'placeholder' => 'jj/mm/aaaa',
                'widget' => 'single_text',
                'format' => 'dd/mm/yyyy',
                'html5' => false,
                'attr' => ['class' => 'input'],
            ])
            ->remove('paysnaissance', CountryType::class, [
                'attr' => ['class' => 'input'], 
                'choice_translation_locale' => null,
                'preferred_choices'=>['FR', 'SN'],
                'label' => 'Pays de naissance *'
                
            ])
            //->add('ville_naissance')
            ->remove('paysresidence', CountryType::class, [
                'attr' => ['class' => 'input'],
                'preferred_choices'=>['FR'], 
                'label' => 'Pays de résidence *'
                
            ])
            ->remove('villeresidence', TextType::class, [
                'label' => 'Ville de résidence *',
                'attr' => ['class' => 'input'], 
                ])
            ->add('profession', TextType::class, [
                'label' => 'Profession *',
                'attr' => ['class' => 'input'], 
                ]) 
            ->add('adresse', TextType::class, [
                'label' => 'Adresse N° de rue et nom *',
                'attr' => ['class' => 'input'], 
                ])
            ->add('codepostal', TextType::class, [
                'label' => 'Code postal *',
                'attr' => ['class' => 'input'], 
                ])
            ->add('ville', TextType::class, [
                'label' => 'Ville *',
                'attr' => ['class' => 'input'], 
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
            ->remove('situationfamiliale', ChoiceType::class, [
                'choices'  => [
                    'Marié(e)' => 'marie',
                    'Pacsé(e)' => 'pasce',
                    'Concubin(e)' => 'concubin',
                    'Célibataire' => 'celibataire',
                    'Divorcé(e)' => 'divorce',
                    'Veuf(ve)' => 'veuf',
                ],
                'choice_attr'=> function($choice, $key, $value) {
                    // adds a class like attending_yes, attending_no, etc
                    return ['class' => 'is-checkradio'];
                },
                'expanded'=>true,
                'multiple'=>false,
                //'label' => 'Situation familiale',
                //'attr' => ['class' => 'is-checkradio'],
                
            ])
            ->remove('nombreenfants', ChoiceType::class, [
                'choices'  => [
                    '0' => '0',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                ],
                'label' => 'Nombre d\'enfants *',
                'attr' => ['class' => 'input'], 
            ])
            ->remove('enfants', CollectionType::class, [
                'entry_type' => EnfantType::class,
                'allow_add'=>true,
                'allow_delete'=>true,
                'by_reference'=>false
                ])
            ->remove('conjoint', ConjointType::class, array(
                'label'=>'Conjoint',
                'required'=>false
            ))

            ->remove('nombrebeneficiaires', ChoiceType::class, [
                'choices'  => [
                    '0' => 'Choisissez 1 ou 2 bénéficiaires',
                    '1' => '1',
                    '2' => '2',
                ],
                'label' => 'Nb bénéficaires *',
                'attr' => ['class' => 'input'],
                'required'=>false, 
                'empty_data' => 'Pas de bénéficiaires' 
            ])
            ->remove('beneficiaires', CollectionType::class, [
                'entry_type' => BeneficiaireType::class,
                'allow_add'=>true,
                'allow_delete'=>true,
                'by_reference'=>false
                ])

            ->remove('cartRecto1', FileType::class, [
                'label' => 'Pièce d\'identité recto(PDF, JPG, PNG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ])
                ],

            ])

            ->remove('cartVerso1', FileType::class, [
                'label' => 'Pièce d\'identité recto(PDF, JPG, PNG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ])
                ],

            ])

            ->remove('cartRecto2', FileType::class, [
                'label' => 'Pièce d\'identité recto du conjoint(PDF, JPG, PNG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ])
                ],

            ])

            ->remove('cartVerso2', FileType::class, [
                'label' => 'Pièce d\'identité recto du conjoint(PDF, JPG, PNG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ])
                ],

            ])

            ->remove('compoMenage', FileType::class, [
                'label' => 'Composition du ménage(PDF, JPG, PNG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ])
                ],

            ])

            ->remove('autreDoc', FileType::class, [
                'label' => 'Autre document(PDF, JPG, PNG)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document',
                    ])
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Souscripteur::class,
        ]);
    }
}
