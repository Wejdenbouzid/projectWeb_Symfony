<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', null, [
            "label" => "Titre",
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "help" => "vous posez une titre ",
            "help_attr" => ["class" => "fs-13 pb-3 lh-20"],
            "attr" => ["class" => "form-control form--control", "placeholder" => "créer une titre"]
        ])
        ->add('detail', null, [
            "label" => "Detail de categorie",
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control user-text-editor", "rows" => 10, "cols" => 40]
        ])
        ->add("submit", SubmitType::class, [
            "label" => "Publier votre categorie",
            "attr" =>["class" => "btn theme-btn"]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
