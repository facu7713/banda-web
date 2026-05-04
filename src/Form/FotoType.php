<?php

namespace App\Form;

use App\Entity\Banda;
use App\Entity\Foto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('imagen', FileType::class, [
                'mapped' => false,
                'required' => false
            ])
            ->add('info', TextareaType::class)
            ->add('categoria', ChoiceType::class, [
                'choices' => [
                    'Promociones' => 'promociones',
                    'Shows en vivo' => 'shows',
                    'Eventos' => 'eventos',
                    'Casamientos' => 'casamientos',
                    'Cumpleaños' => 'cumpleanos',
                    'Backstage' => 'backstage',
                    'Escenario' => 'escenario',
                    'Público' => 'publico',
                    'Flyers' => 'flyers',
                    'Institucional' => 'institucional',
                ],
                'placeholder' => 'Seleccionar categoría'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Foto::class,
        ]);
    }
}
