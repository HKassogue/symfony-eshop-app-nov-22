<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormTypeInterface;
use App\Entity\ResetPassword;


class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
        ->add('new_password', RepeatedType::class, [
            // 'mapped' => false,
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe ne sont pas identiques',
            'required' => true,
            'constraints' => new Length([
                'min' => 8,
                'minMessage' => 'Le mot de passe est trop court. Il faut 8 caractères au moins'
            ]),
            'first_options' => [
                'label' => 'Nouveau mot de passe', 
                'attr' => [
                    'placeholder' => 'Entrez votre nouveau mot de passe'
                ]
            ],
            'second_options' => [
                'label' => 'Confirmation du nouveau mot de passe',
                'attr' => [
                    'placeholder' => 'Entrez encore votre nouveau mot de passe pour confirmer'
                ]
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Mettre a jour'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
