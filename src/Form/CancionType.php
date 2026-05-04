<?php

namespace App\Form;

use App\Entity\Banda;
use App\Entity\Cancion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CancionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('audio', FileType::class, [
                'mapped' => false, 
                'required' => false
            ])
            ->add('tipo', ChoiceType::class, [
                'choices' => [
                    'Cumbia' => 'cumbia',
                    'Cuarteto' => 'cuarteto',
                    'Folklore' => 'folklore',
                    'Chamame' => 'chamame',
                    'Paso Doble' => 'paso_doble',
                    'Latinos' => 'latinos',
                    'Rock Nacional' => 'rock_nacional',
                    'Melodicos' => 'melodicos',
                ],
                'placeholder' => 'Seleccionar genero'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cancion::class,
        ]);
    }
}
