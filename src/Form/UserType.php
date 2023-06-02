<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom',null,[ 
            "label" => "Nom", 
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control","placeholder"=>"Entrez nom"]
        ])
        ->add('prenom',null,[
            "label" => "Prenom", 
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control","placeholder"=>"Entrez prenom"]
        ])
        ->add('phone',null,[
            "label" => "Phone", 
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control","placeholder"=>"Entrez phone"]
        ])
        ->add('adresse',null,[
            "label" => "Adresse", 
            "attr" => ["class" => "form-control form--control user-text-editor","rows" => 10, "cols" => 40, "placeholder"=>"Entrez adresse"]
        ])
        ->add('email',null,[
            "label" => "Email", 
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control","placeholder"=>"Votre email"]
        ])
        ->add('password',null,[
            "label" => "Password", 
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control", "placeholder"=>"Votre password"]
        ])

        ->add("submit", SubmitType::class, [
            "label" => "Publier",
            "attr" =>["class" => "btn theme-btn"]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
