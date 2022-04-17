<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Games;



use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GamesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                "required" => false,
            ])
            ->add('description',TextareaType::class, [
                "required" => false,
            ])
            ->add('rate')
            ->add('img', FileType::class, [
                "data_class"=>null,
                "attr"=>["class"=> "form-control"]
            ])
            ->add('Category', EntityType::class,[
                    "class" => Category::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Games::class,
        ]);
    }
}
