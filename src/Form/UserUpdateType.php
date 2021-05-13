<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,[
                'disabled' => true,
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class,[
                'disabled' => true,
                'label' => 'Nom'
            ])
            ->add('email',EmailType::class,[
                'disabled' => true,
                'label' => 'Mon adresse email'
            ])
            ->add('roles', ChoiceType::class,[
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Manager' => 'ROLE_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Roles',
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour",
                'attr' => [
                    'class' => 'btn-block btn-info',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
