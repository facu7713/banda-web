<?php

namespace App\Controller\Admin;

use App\Entity\Show;
use App\Entity\Banda;
use App\Entity\Evento;
use App\Form\ShowType;
use App\Repository\ShowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/show')]
class ShowController extends AbstractController
{
    #[Route('', name: 'admin_show')]
    public function show_index(Request $request, ShowRepository $repo): Response
    {

        $shows = $repo->createQueryBuilder('s')
            ->leftJoin('s.evento', 'e')->addSelect('e')
            ->orderBy('s.fecha', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('admin/show/index.html.twig', [
            'shows' => $shows,
            'key' => $request->query->get('key')
        ]);
    }

    #[Route('/new', name: 'admin_show_new')]
    public function show_new(Request $request, EntityManagerInterface $em): Response
    {

        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $banda = $em->getRepository(Banda::class)->find(1);
            $show->setBanda($banda);

            $em->persist($show);
            $em->flush();

            return $this->redirectToRoute('admin_show', [
                'key' => $request->query->get('key')
            ]);
        }

        return $this->render('admin/show/show_new.html.twig', [
            'form' => $form->createView(),
            'key' => $request->query->get('key')
        ]);
    }

    #[Route('/edit/{id}', name: 'admin_show_edit')]
    public function show_edit(Show $show, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $banda = $em->getRepository(Banda::class)->find(1);
            $show->setBanda($banda);

            $em->flush();

            return $this->redirectToRoute('admin_show', [
                'key' => $request->query->get('key')
            ]);
        }

        return $this->render('admin/show/show_edit.html.twig', [
            'form' => $form->createView(),
            'key' => $request->query->get('key')
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_show_delete')]
    public function show_delete(Show $show, Request $request, EntityManagerInterface $em): Response
    {

        $em->remove($show);
        $em->flush();

        return $this->redirectToRoute('admin_show', [
            'key' => $request->query->get('key')
        ]);
    }
}