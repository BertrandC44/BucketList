<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/wish', name: 'wish')]
final class WishController extends AbstractController
{

    #[Route('/list/{page}', name: '_listpage',requirements: ['page' => '\d+'], defaults: ['page' => 1], methods: ['GET'])]
    public function list(WishRepository $wishRepository,int $page,ParameterBagInterface $parameters): Response
    {
        /*$wishes = $wishRepository->findAll();
        dd($wishes);*/

        $nbParPage = $parameters->get('wishes')['nb_max'];
        $offset = ($page - 1) * $nbParPage;
        $criterias =
            [
                'isPublished'=> '1'
            ];
        $wishes = $wishRepository->findBy(
            $criterias,
            null,
            $nbParPage,
            $offset
        );
        $total = $wishRepository->count($criterias);
        $totalPages = ceil($total / $nbParPage);


        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes,
            'page' => $page,
            'total_pages' => $totalPages,
        ]);
    }

    #[Route('/list-custom', name: '_custompage')]
    public function listCustom(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findWishCustom('henri',8);
        return $this->render('wish/list.html.twig',[
            'wishes' => $wishes,
            'page' => 1,
            'totalPages' => 30,
        ]);
    }

    #[Route('/detail/{id}', name: '_detailpage', requirements: ['id' => '\d+'], defaults: ['id' => 0])]
    public function detail(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);
        /*dd($wish);*/

        /*if (!$wish) {
            throw $this->createNotFoundException('Il n\'y a pas de souhait demandé');
        }*/

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish,
        ]);
    }
}
