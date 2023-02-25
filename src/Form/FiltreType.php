<?php

namespace App\Form;

use App\Data\filtre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface as FormFormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreType extends AbstractType{

    public function buildForm(FormFormBuilderInterface $builder, array $options): void{
        $builder
        ->add('min',NumberType::class,[
            'label'=>false,
            'required'=>false,
            'attr'=>[
                'placeholder'=>'Prix min'
            ]
        ])
        ->add('max',NumberType::class,[
            'label'=>false,
            'required'=>false,
            'attr'=>[
                'placeholder'=>'Prix max'
            ]
        ])
        ->add('Filtrer',SubmitType::class,[
            
            
        ])
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => filtre::class,
            'method'=> 'POST',
            'csrf_protection'=>false
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}