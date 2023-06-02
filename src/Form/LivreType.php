<?php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', null, [
            "label" => "Titre de livre",
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control", "placeholder" => "Ajouter titre de livre"]
        ])

        ->add('auteur', null, [
            "label" => "Auteur de livre",
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control", "placeholder" => "Ajouter auteur de livre"]
        ])
        ->add('detail', null, [
            "label" => "Contenu de livre",
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control user-text-editor", "rows" => 10, "cols" => 40]
        ])
        ->add('prix',null, [
            "label" => "Prix de livre",
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control", "placeholder" => "prix de livre"]
        ])
        ->add("submit", SubmitType::class, [
            "label" => "Publier votre livre",
            "attr" =>["class" => "btn theme-btn"]
        ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
