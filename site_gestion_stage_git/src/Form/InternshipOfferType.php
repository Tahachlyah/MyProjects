<?php

namespace App\Form;

use App\Entity\Duration;
use App\Entity\InternshipOffer;
use App\Entity\InternshipTheme;
use App\Entity\InternshipSupervisor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InternshipOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('theme', EntityType::class,[
                'class' => InternshipTheme::class,
                'choice_label' => 'name'

        ])
            ->add('location')
            ->add('description')
            ->add('duration', EntityType::class,[
                'class' => Duration::class,
                'choice_label' => 'name'

        ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InternshipOffer::class,
        ]);
    }
}
