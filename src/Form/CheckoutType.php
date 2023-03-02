<?php

namespace App\Form;

use App\Entity\Delivery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                'label' => 'Address Line 1',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('zipcode', TextType::class, [
                'attr'=>[
                    'placeholder' => '123',
                    'class'=>'form-control'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            //->add('price')
            ->add('state', TextType::class, [
                'label' => 'State',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('address2', TextType::class, [
                'label' => 'Address Line 2',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'John',
                    'class' => 'form-control'
                ]
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Doe',
                    'class' => 'form-control'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'example@email.com',
                    'class' => 'form-control'
                ]
            ])
            ->add('tel', TelType::class, [
                'attr'=>[
                    'placeholder' => '+123 456 789',
                    'class'=>'form-control'
                ]
            ])
            ->add('country', CountryType::class)
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'id' => 'checkout-button'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Delivery::class,
        ]);
    }
}
