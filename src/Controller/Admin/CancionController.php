<?php

namespace App\Controller\Admin;

use App\Entity\Cancion;
use App\Entity\Banda;
use App\Form\CancionType;
use App\Repository\CancionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/cancion')]
class CancionController extends AbstractController
{
    #[Route('', name: 'admin_cancion')]
    public function cancion_index(Request $request, CancionRepository $repo): Response
    {
        $canciones = $repo->findBy([], ['id' => 'DESC']);

        return $this->render('admin/cancion/index.html.twig', [
            'canciones' => $canciones,
            'key' => $request->query->get('key')
        ]);
    }

    #[Route('/new', name: 'admin_cancion_new')]
    public function new_cancion(Request $request, EntityManagerInterface $em): Response
    {
        $cancion = new Cancion();
        $form = $this->createForm(CancionType::class, $cancion);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            $audioFile = $form->get('audio')->getData();
    
            if ($audioFile) {
                $extension = $audioFile->guessExtension() ?: 'mp3';
                $newFilename = 'cancion_' . time() . '.' . $extension;
    
                $audioFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/cancion',
                    $newFilename
                );
    
                $cancion->setAudio($newFilename);
    
            } else {
                $cancion->setAudio('sin_audio.mp3');
            }
    
            $banda = $em->getRepository(Banda::class)->find(1);
    
            if (!$banda) {
                throw new \Exception('No existe banda ID 1');
            }
    
            $cancion->setBanda($banda);
    
            $em->persist($cancion);
            $em->flush();
    
            return $this->redirectToRoute('admin_cancion', [
                'key' => $request->query->get('key')
            ]);
        }
    
        return $this->render('admin/cancion/new_cancion.html.twig', [
            'form' => $form->createView(),
            'key' => $request->query->get('key')
        ]);
    }

    #[Route('/edit/{id}', name: 'admin_cancion_edit')]
    public function edit_cancion(Cancion $cancion, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(CancionType::class, $cancion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 🎧 AUDIO NUEVO 
            $audioFile = $form->get('audio')->getData();

            if ($audioFile) {

                // 🗑️ BORRAR AUDIO ANTERIOR
                if ($cancion->getAudio()) {
                    $oldFile = $this->getParameter('kernel.project_dir') . '/public/uploads/cancion/' . $cancion->getAudio();

                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                // 💾 GUARDAR NUEVO AUDIO
                $extension = $audioFile->guessExtension() ?: 'mp3';
                $newFilename = 'cancion_' . time() . '.' . $extension;

                $audioFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/cancion',
                    $newFilename
                );

                $cancion->setAudio($newFilename);
            }

            $em->flush();

            return $this->redirectToRoute('admin_cancion', [
                'key' => $request->query->get('key')
            ]);
        }

        return $this->render('admin/cancion/edit_cancion.html.twig', [
            'form' => $form->createView(),
            'key' => $request->query->get('key'),
            'cancion' => $cancion
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_cancion_delete')]
    public function delete_cancion(Cancion $cancion, Request $request, EntityManagerInterface $em): Response
    {

        // 🗑️ BORRAR ARCHIVO FÍSICO
        if ($cancion->getAudio()) {

            $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/cancion/' . $cancion->getAudio();

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // 🗑️ BORRAR DE LA DB
        $em->remove($cancion);
        $em->flush();

        return $this->redirectToRoute('admin_cancion', [
            'key' => $request->query->get('key')
        ]);
    }


}
