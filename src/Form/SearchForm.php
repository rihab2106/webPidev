<?php
namespace App\Form;
use App\Entity\Category;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Data\SearchInfo;

class SearchForm extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q',TextType::class,[
                'label'=>false,
        'required'=>false,
        'attr'=>['placeholder' => 'Search']
    ])
    ->add('categories',EntityType::class,[
        'label'=>false,
        'required'=> false,
        'class'=>Category::class,
        'expanded'=>true,
        'multiple'=>true
    ])
    ->add('min',NumberType::class,[
        'label'=>false,
        'required'=> false,
        'attr'=>[
            'placeholder' => 'MIN PRICE'
        ]
    ])->add('max',NumberType::class,[
                'label'=>false,
                'required'=> false,
                'attr'=>[
                    'placeholder' => 'MAX PRICE'
                ]
            ])
//            ->add('discount',CheckboxType::class,[
//                'label'=>'have discount',
//                'required'=> false,
//
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {$resolver->setDefaults([
        'data_class'=>SearchInfo::class,
        'method'=>'GET',
        'csrf_protection'=> false
    ]);


    }
    public function getBlockPrefix()
    {
        return '';
    }
}