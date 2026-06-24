<?php

namespace App\Controller;

use App\Entity\Comentario;
use App\Form\ComentarioType;
use App\Repository\ComentarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComentarioController extends AbstractController
{
    #[Route('/comentarios', name: 'comentarios')]
    public function index(Request $request,EntityManagerInterface $em,ComentarioRepository $repo): Response {

        // nuevo comentario
        $comentario = new Comentario();

        // formulario
        $form = $this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);

        // guardar
        if ($form->isSubmitted() && $form->isValid()) {

            // visible por defecto ya lo tenés en true
            $em->persist($comentario);
            $em->flush();

            // mensaje flash
            $this->addFlash('success', 'Comentario enviado correctamente');

            return $this->redirectToRoute('comentarios', [
                'highlight' => $comentario->getId()
            ]);
        }

        // traer comentarios visibles
        $comentarios = $repo->findBy(
            ['visible' => true],
            ['fechaPublicacion' => 'DESC']
        );

        return $this->render('sitio_publico/comentario/index.html.twig', [
            'form' => $form->createView(),
            'comentarios' => $comentarios
        ]);
    }

    #[Route('/admin/comentarios', name: 'admin_comentarios')]
    public function admin(ComentarioRepository $repo): Response
    {
        $comentarios = $repo->findBy([], ['fechaPublicacion' => 'DESC']);

        return $this->render('admin/comentarios/index.html.twig', [
            'comentarios' => $comentarios
        ]);
    }
    #[Route('/admin/comentario/{id}/toggle', name: 'admin_comentario_toggle')]
    public function toggle(Comentario $comentario, EntityManagerInterface $em): Response
    {
        $comentario->setVisible(!$comentario->isVisible());

        $em->flush();

        return $this->redirectToRoute('admin_comentarios');
    }
    #[Route('/admin/comentario/{id}/delete', name: 'admin_comentario_delete')]
    public function delete(Comentario $comentario, EntityManagerInterface $em): Response
    {
        $em->remove($comentario);
        $em->flush();

        $this->addFlash('danger', 'Comentario eliminado correctamente');

        return $this->redirectToRoute('admin_comentarios');
    }
}
