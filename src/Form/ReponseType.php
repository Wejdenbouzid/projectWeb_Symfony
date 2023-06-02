<?php

namespace App\Form;

use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('contenu', null, [
            "label" => "Contenu de votre question",
            "label_attr" => ["class" => "fs-14 text-black fw-medium mb-0"],
            "attr" => ["class" => "form-control form--control user-text-editor", "rows" => 10, "cols" => 40]
        ])
        ->add("submit", SubmitType::class, [
            "label" => "Publier votre réponse",
            "attr" =>["class" => "btn theme-btn"]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}
