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
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

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
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Merci de saisir votre mot de passe'
                ],
                'mapped' => false,
                'label' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",
                'attr' => [
                    'class' => 'signupbtn',
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
