<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre del video'
            ])
            ->add('url', TextType::class, [
                'label' => 'URL de YouTube',
                'help' => 'Ej: https://www.youtube.com/watch?v=XXXX'
            ])
            ->add('info', TextType::class, [
                'label' => 'Descripción'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}