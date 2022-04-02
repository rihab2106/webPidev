<?php

namespace App\Form;

use App\Entity\Trophies;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrophiesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('platform', ChoiceType::class, [
                "choices"=> ["PS4", "PS5", "XBox Series X|S", "XBox One", "Nintendo Switch", "PC" ],
                "choice_label"=> function ($choice, $key, $value){
                return $value;
                }

            ])
            ->add('difficulity', ChoiceType::class, [
                "choices"=> ["Very Easy", "Easy", "Medium","Hard", "Very Hard"],
                "choice_label"=> function ($choice, $key, $value){
                return $value;
                }
            ])
            ->add('idGame')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trophies::class,
        ]);
    }
}
