<?php

namespace App\Form;

use App\Entity\Mount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('faction', ChoiceType::class,[
                'choices' => [
                    'All' => 'All',
                    'Alliance' => 'Alliance',
                    'Horde' => 'Horde'
                ],
            ])
            ->add('type', ChoiceType::class,[
                'choices' => [
                    'All' => 'All',
                    'Eartly' => 'Earthly',
                    'Flying' => 'Flying',
                    'Aquatic' => 'Aquatic'
                ],
            ])
            ->add('currency_type')
            ->add('expansion')
            ->add('source', ChoiceType::class,[
                'choices' => [
                    'All' => 'All',
                    'Shop' => 'Shop',
                    'Seller' => 'Seller',
                    'Quest' => 'Quest'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mount::class,
        ]);
    }
}
