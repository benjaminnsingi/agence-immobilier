<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class)
            ->add('description',TextareaType::class)
            ->add('surface', NumberType::class)
            ->add('rooms',NumberType::class)
            ->add('bedrooms',NumberType::class)
            ->add('floor',NumberType::class)
            ->add('price',NumberType::class)
            ->add('heat',NumberType::class)
            ->add('city',TextType::class)
            ->add('address',TextType::class)
            ->add('postal_code',TextType::class)
            ->add('sold')
            ->add('lat',HiddenType::class)
            ->add('lng',HiddenType::class)
            ->add('options',EntityType::class,[
                'class' => Option::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
