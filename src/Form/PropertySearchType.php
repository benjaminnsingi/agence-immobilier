<?php


namespace App\Form;



use App\Data\SearchData;
use App\Entity\Category;
use App\Entity\Option;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minSurface', HiddenType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Surface minimale'
                ]
            ])
            ->add('maxPrice', HiddenType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget max'
                ]
            ])
            ->add('address', null, [
                'label' => false,
                'required' => false,
            ])
            ->add('distance', HiddenType::class)
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
