<?php

namespace App\Form;

use App\Entity\Comentario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComentarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Tu nombre',
                'attr' => [
                    'placeholder' => 'Ej: Juan Pérez'
                ]
            ])

            ->add('puntuacion', IntegerType::class, [
                'label' => 'Puntuación (1 a 5)',
                'attr' => [
                    'min' => 1,
                    'max' => 5
                ]
            ])

            ->add('mensaje', TextareaType::class, [
                'label' => 'Comentario',
                'attr' => [
                    'placeholder' => 'Escribí tu experiencia...',
                    'rows' => 4
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comentario::class,
        ]);
    }
}