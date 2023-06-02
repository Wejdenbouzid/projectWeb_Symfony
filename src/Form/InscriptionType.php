<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',null,[ 
                "label" => " ", 
                "attr" => ["placeholder"=>"Votre nom"]
            ])
            ->add('prenom',null,[
                "label" => " ", 
                "attr" => ["placeholder"=>"Votre prenom"]
            ])
            ->add('phone',null,[
                "label" => " ", 
                "attr" => ["placeholder"=>"Votre phone"]
            ])
            ->add('adresse',null,[
                "label" => " ", 
                "attr" => ["rows" => 10, "cols" => 40, "placeholder"=>"Votre adresse"]
            ])
            ->add('email',null,[
                "label" => " ", 
                "attr" => ["placeholder"=>"Votre email"]
            ])
            ->add('password',null,[
                "label" => " ", 
                "attr" => [ "placeholder"=>"Votre password"]
            ])

            ->add("submit", SubmitType::class, [
                "label" => "Inscription",
                "attr" =>["class" => "form-group form-button form-submit"]
            ])
            #->add('roles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
