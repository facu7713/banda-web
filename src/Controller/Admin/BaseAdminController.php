<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BaseAdminController extends AbstractController
{
    protected function checkAccess(Request $request): void
    {
        if ($request->query->get('key') !== $_ENV['ADMIN_KEY']) {
            throw $this->createAccessDeniedException();
        }
    }
}
