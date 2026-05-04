<?php

namespace App\Controller\Admin;

use App\Entity\Foto;
use App\Entity\Banda;
use App\Form\FotoType;
use App\Repository\FotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/foto')]
class FotoController extends AbstractController
{
    #[Route('', name: 'admin_foto')]
    public function foto_index(Request $request, FotoRepository $repo): Response
    {
    
        $fotos = $repo->findBy([], ['id' => 'DESC']);
    
        return $this->render('admin/foto/index.html.twig', [
            'fotos' => $fotos,
            'key' => $request->query->get('key')
        ]);
    }

    #[Route('/new', name: 'admin_foto_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {

        $foto = new Foto();
        $form = $this->createForm(FotoType::class, $foto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('imagen')->getData();

            if ($file) {
                $newFilename = 'foto_' . time() . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/fotos',
                    $newFilename
                );

                $foto->setImagen($newFilename);
            }

            $banda = $em->getRepository(Banda::class)->find(1);
            $foto->setBanda($banda);

            $em->persist($foto);
            $em->flush();

            return $this->redirectToRoute('admin_foto', [
                'key' => $request->query->get('key')
            ]);
        }

        return $this->render('admin/foto/new_foto.html.twig', [
            'form' => $form->createView(),
            'key' => $request->query->get('key')
        ]);
    }

    #[Route('/edit/{id}', name: 'admin_foto_edit')]
    public function edit_foto(Foto $foto, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(FotoType::class, $foto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('imagen')->getData();

            if ($file) {

                // borrar anterior
                if ($foto->getImagen()) {
                    $old = $this->getParameter('kernel.project_dir') . '/public/uploads/fotos/' . $foto->getImagen();
                    if (file_exists($old)) unlink($old);
                }

                $newFilename = 'foto_' . time() . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads/fotos',
                    $newFilename
                );

                $foto->setImagen($newFilename);
            }

            $em->flush();

            return $this->redirectToRoute('admin_foto', [
                'key' => $request->query->get('key')
            ]);
        }

        return $this->render('admin/foto/edit_foto.html.twig', [
            'form' => $form->createView(),
            'foto' => $foto,
            'key' => $request->query->get('key')
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_foto_delete')]
    public function delete(Foto $foto, Request $request, EntityManagerInterface $em): Response
    {

        if ($foto->getImagen()) {
            $path = $this->getParameter('kernel.project_dir') . '/public/uploads/fotos/' . $foto->getImagen();

            if (file_exists($path)) unlink($path);
        }

        $em->remove($foto);
        $em->flush();

        return $this->redirectToRoute('admin_foto', [
            'key' => $request->query->get('key')
        ]);
    }

}
