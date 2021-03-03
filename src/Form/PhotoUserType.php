<?php

namespace App\Form;

use App\Entity\PhotoUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image;

class PhotoUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('photo', FileType::class, [
            'data_class' => null,
            'label' => 'Image(JPG, PNG)',
            'required' => true,
            'constraints' => [
                new Image(),
                ]
                ])
            //->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PhotoUser::class,
        ]);
    }
}
