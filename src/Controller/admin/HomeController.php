<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin')]
class HomeController extends AbstractController
{
    #[Route(name: 'app_home_dashboard')]
    public function index(): Response
    {
        return $this->render('admin/home.html.twig');
    }
}
