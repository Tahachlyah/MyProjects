<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\InternshipOffer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message')
            // ->add('user')
            ->add('internshipOffer', )
            // ->add('sponsor')
            ->add('internshipOffer', EntityType::class,[
                'class' => InternshipOffer::class,
                'choice_label' => 'title'

        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
