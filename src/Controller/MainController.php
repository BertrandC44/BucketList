<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function home(): Response
    {
        return $this->render('main/index.html.twig');

    }




    #[Route('/AboutUs', name: 'app_aboutus')]
    public function AboutUS(): Response
    {
        return $this->render('main/AboutUs.html.twig');

    }

}
