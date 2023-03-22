<?php

namespace App\Form;

use App\Data\Filtre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface as FormFormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreType extends AbstractType{

    public function buildForm(FormFormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('min', MoneyType::class,[
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix min'
                ],
                'currency' => 'XOF',
                'divisor' => 1
            ])
            ->add('max', MoneyType::class,[
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Prix max'
                ],
                'currency' => 'XOF',
                'divisor' => 1
            ])
            ->add('Filtrer',SubmitType::class,[ 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filtre::class,
            'method' => 'POST',
            'csrf_protection' => true
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}