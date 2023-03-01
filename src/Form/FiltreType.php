<?php

namespace App\Form;

use App\Classes\filtre;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function PHPSTORM_META\type;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('string', TextType::class,[
            'label' => 'Rechercher',
            'attr' => [
                'placeholder' => 'Votre Recherche'
            ]
            ]
         )
         ->add('categories', EntityType::class,[
            'label'  => false,
            'required' => false,
            'class' => Category::class,
            'multiple' => true,
            'expanded' => true,
         ])
         ->add('submit', SubmitType::class,[
            'label' => 'Filtrer',
         ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => filtre::class,
            'method' => 'GET',
            'csrf_protection'=>false
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}