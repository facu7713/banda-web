<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Evento;
use App\Entity\Banda;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $eventos = [
            ['Privado', 'privado.webp', 'Shows exclusivos para eventos privados'],
            ['Empresarial', 'empresarial.jpg', 'Eventos corporativos'],
            ['Casamiento', 'casamiento.jpeg', 'La música para tu gran día'],
            ['Festival', 'festivales.webp', 'Shows para grandes públicos'],
            ['Cumpleaño', 'cumpleaños.jpg', 'Animación y fiesta'],
            ['Bar', 'bares.jpg', 'Ambiente musical'],
            ['Boliche', 'boliches.webp', 'Energía para la noche'],
        ];
        
        foreach ($eventos as $e) {
            $evento = new Evento();
            $evento->setNombre($e[0]);
            $evento->setFoto($e[1]);
            $evento->setInfo($e[2]);
        
            $manager->persist($evento);
        }

        $manager->flush(); 

        $banda = new Banda();
        $banda->setNombre('ULI y Los Complices Fantasmas');
        $manager->persist($banda);
        $manager->flush();
    }
}
