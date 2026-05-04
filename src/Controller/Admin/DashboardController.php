<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class DashboardController extends AbstractController
{
    #[Route('', name: 'admin')]
    public function index(Request $request): Response
    {
        return $this->render('admin/index.html.twig', [
            'key' => $request->query->get('key')
        ]);
    }
}