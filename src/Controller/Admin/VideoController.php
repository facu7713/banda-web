<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use App\Entity\Banda;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/videoss')]
class VideoController extends AbstractController
{
    #[Route('', name: 'admin_video')]
    public function video_index(Request $request, VideoRepository $repo): Response
    {
        $videos = $repo->findBy([], ['fecha' => 'DESC']);

        return $this->render('admin/video/index.html.twig', [
            'videos' => $videos,
            'key' => $request->query->get('key')
        ]);
    }

    #[Route('/new', name: 'admin_video_new')]
    public function new_video(Request $request, EntityManagerInterface $em): Response
    {

        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $banda = $em->getRepository(Banda::class)->find(1);
            $video->setBanda($banda);

            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute('admin_video', [
                'key' => $request->query->get('key')
            ]);
        }

        return $this->render('admin/video/new_video.html.twig', [
            'form' => $form->createView(),
            'key' => $request->query->get('key')
        ]);
    }

    #[Route('/edit/{id}', name: 'admin_video_edit')]
    public function edit_video(Video $video, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('admin_video', [
                'key' => $request->query->get('key')
            ]);
        }

        return $this->render('admin/video/edit_video.html.twig', [
            'form' => $form->createView(),
            'key' => $request->query->get('key'),
            'video' => $video
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_video_delete')]
    public function delete_video(Video $video, Request $request, EntityManagerInterface $em): Response
    {

        $em->remove($video);
        $em->flush();

        return $this->redirectToRoute('admin_video', [
            'key' => $request->query->get('key')
        ]);
    }
}
