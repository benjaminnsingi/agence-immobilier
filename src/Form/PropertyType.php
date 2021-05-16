<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Option;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('title',TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description',TextareaType::class,[
                'label' => 'Description'
            ])
            ->add('surface', NumberType::class,[
                'label' => 'Surface'
            ])
            ->add('rooms',NumberType::class,[
                'label' => 'Pièce(s)'
            ])
            ->add('bedrooms',NumberType::class,[
                'label' => 'Chambre à coucher'
            ])
            ->add('floor',NumberType::class,[
                'label' => 'Etage'
            ])
            ->add('price',NumberType::class,[
                'label' => 'Prix'
            ])
            ->add('heat', ChoiceType::class, [
                'label' => 'Chauffage',
                'choices' => $this->getChoices()
            ])
            ->add('city',TextType::class,[
                'label' => 'Ville'
            ])
            ->add('address',TextType::class,[
                'label' => 'Adresse'
            ])
            ->add('postal_code',TextType::class,[
                'label' => 'Code postal'
            ])
            ->add('sold',CheckboxType::class,[
                'label' => 'Vendu',
                'required' => false
            ])
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
            'translation_domain' => 'forms'
        ]);
    }

    private function getChoices()
    {
        $choices = Property::HEAT;
        $output = [];
        foreach($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
