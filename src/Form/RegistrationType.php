<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,[
                 'label' => 'Prénom',
                 'attr' => [
                    'placeholder' => 'Merci de saisir votre prénom',
                     'class' => 'form-control'
                 ]
            ])
            ->add('lastname',TextType::class,[
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nom',
                    'class' => 'form-control'
                ]
            ])
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre adresse email',
                    'class' => 'form-control'
                ]
            ])
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
                'label' => 'Votre mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                     'attr' => [
                         'placeholder' => 'Merci de saisir votre mot de passe',
                         'class' => 'form-control',
                     ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci  de confirmer votre mot de passe',
                        'class' => 'form-control',
                    ]
                ],
                'attr' => [
                    'placeholder' => 'Merci de saisir votre mot de passe',
                    'class' => 'form-control'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",
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
