<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {$formOptions = [
        'disabled' => 'true',
        
        'attr' => ['class' => 'save btn-primary btn'],
       
       
    ];

    // create the field, this is similar the $builder->add()
    // field name, field type, field options
    
        $builder
            ->add('comment')
            ->add('Add Comment',SubmitType::class,$formOptions)
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
