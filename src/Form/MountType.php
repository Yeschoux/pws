<?php

namespace App\Form;

use App\Entity\Mount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('image', FileType::class,[
                'label' => 'Place Main Image',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File ([
                        'maxSize' => '5000k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image File',
                    ])
                ],
            ])
            ->add('description')
            ->add('faction', ChoiceType::class,[
                'choices' => [
                    'Alliance' => 'Alliance',
                    'Horde' => 'Horde',
                    'All' => 'All'
                ],
            ])
            ->add('type', ChoiceType::class,[
                'choices' => [
                    'Eartly' => 'Earthly',
                    'Flying' => 'Flying',
                    'Aquatic' => 'Aquatic',
                    'All' => 'All'
                ],
            ])
            ->add('currency')
            ->add('currency_type')
            ->add('expansion')
            ->add('source')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mount::class,
        ]);
    }
}
