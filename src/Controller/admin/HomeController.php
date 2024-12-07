<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/admin', name: 'app_home_dashboard')]
    public function index(): Response
    {
        return $this->render('admin/home.html.twig');
    }
}
