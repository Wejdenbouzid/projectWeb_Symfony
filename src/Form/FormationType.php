<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
            "label" => "Titre de formation",
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control", "placeholder" => "Ajouter titre "]
            ])

            ->add('formateur', null, [
            "label" => "Formateur",
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control", "placeholder" => "Ajouter formateur"]
            ])
            ->add('contenu', null, [
            "label" => "Contenu de formation",
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control user-text-editor", "rows" => 10, "cols" => 40]
            ])
            ->add("submit", SubmitType::class, [
                "label" => "Publier votre formation",
                "attr" =>["class" => "btn theme-btn"]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
