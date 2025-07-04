<?php

namespace App\Form;

use App\Entity\FestivalArtist;
use App\Entity\Festival;
use App\Entity\Artist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FestivalArtistForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('festival', EntityType::class, [
                'class' => Festival::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a festival',
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'name',
                'placeholder' => 'Select an artist',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Add Artist to Festival'
            ]);
    }
}
