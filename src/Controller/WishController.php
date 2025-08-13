<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/wish', name: 'wish')]
final class WishController extends AbstractController
{

    #[Route('/list', name: '_listpage')]
    public function list(): Response
    {

        return $this->render('wish/list.html.twig');
    }

    #[Route('/detail/{id}', name: '_detailpage', requirements: ['id' => '\d+'], defaults: ['id' => 0])]
    public function detail(int $id, Request $request): Response
    {

        return $this->render('wish/detail.html.twig', [
            'id' => $id,
        ]);
    }
}
