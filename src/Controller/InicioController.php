<?php

namespace App\Controller;
use App\Repository\EventoRepository;
use App\Repository\ShowRepository;
use App\Repository\CancionRepository;
use App\Repository\VideoRepository;
use App\Repository\FotoRepository;

use App\Entity\Show;
use App\Entity\Banda;
use App\Entity\Cancion;
use App\Entity\Foto;
use App\Entity\Video;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class InicioController extends AbstractController
{
    #[Route('/', name: 'inicio')]
    public function index(EventoRepository $eventoRepository)
    {
        $eventos = $eventoRepository->findAll();

        return $this->render('inicio/index.html.twig', [
            'eventos' => $eventos,
        ]);
    }

    #[Route('/shows', name: 'shows')]
    public function shows(ShowRepository $repo): Response
    {
        $shows = $repo->createQueryBuilder('s')
            ->leftJoin('s.evento', 'e')->addSelect('e')
            ->orderBy('s.fecha', 'ASC')
            ->getQuery()
            ->getResult();

        $now = new \DateTime();

        $proximos = [];
        $realizados = [];

        foreach ($shows as $show) {
            if ($show->getFecha() > $now) {
                $proximos[] = $show;
            } else {
                $realizados[] = $show;
            }
        }

        return $this->render('shows/index.html.twig', [
            'proximos' => $proximos,
            'realizados' => $realizados
        ]);
    }

    #[Route('/galeria', name: 'galeria')]
    public function galeria(CancionRepository $cancionRepository, 
    VideoRepository $videoRepository, 
    FotoRepository $fotoRepository)
    {
        $canciones = $cancionRepository->findBy([], ['id' => 'ASC']);
        $videos = $videoRepository->findBy([], ['fecha' => 'ASC']);
        $fotos = $fotoRepository->findBy([], ['fecha' => 'ASC']);

        return $this->render('galeria/index.html.twig', [
            'canciones' => $canciones,
            'videos' => $videos,
            'fotos' => $fotos,
        ]);
    }

    #[Route('/banda', name: 'banda')]
    public function banda()
    {
        return $this->render('banda/index.html.twig');
    }

    #[Route('/contacto', name: 'contacto')]
    public function contacto()
    {
        return $this->render('contacto/index.html.twig');
    }
}
