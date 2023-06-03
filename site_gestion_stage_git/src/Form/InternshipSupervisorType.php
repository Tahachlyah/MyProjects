<?php

namespace App\Form;

use App\Entity\InternshipSupervisor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InternshipSupervisorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('post')
            ->add('companyName')
            ->add('description')
            ->add('field')
            ->add('siretNumber')
            ->add('companyAdress')
            // TODO ajouter filetype pour charger image 
            ->add('companyPicture')
            ->add('PictureDescription') 

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InternshipSupervisor::class,
        ]);
    }
}
