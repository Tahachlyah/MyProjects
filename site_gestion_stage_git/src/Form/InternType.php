<?php

namespace App\Form;

use App\Entity\Intern;
use App\Entity\LevelStudies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class InternType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        //ajouter la methode pour importer une image 
        ->add('avatar', FileType::class,[
            'label' => 'chargez une image',
            'data_class' => null,
            'required' => false
    ])
        ->add('institution')
        //TODO ajouter une methode pour importer un pdf
        ->add('cv')
        ->add('levelStudies', EntityType::class,[
            'class' => LevelStudies::class,
            'choice_label' => 'name'

    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intern::class,
        ]);
    }
}
