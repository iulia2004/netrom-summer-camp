<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FestivalForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class)
        ->add('location', TextType::class)
        ->add('start_date', DateType::class)
        ->add('end_date', DateType::class)
        ->add('price', NumberType::class)
        ->add('save', SubmitType::class)
        ->getForm();
    }
}
