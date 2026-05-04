<?php

namespace App\Form;

use App\Entity\Banda;
use App\Entity\Evento;
use App\Entity\Show;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('evento', EntityType::class, [
                'class' => Evento::class,
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccionar evento',
                'required' => true
            ])
            ->add('lugar', TextType::class)
            ->add('ciudad', TextType::class)
            ->add('fecha', DateTimeType::class, [
                'widget' => 'single_text'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Show::class,
        ]);
    }
}