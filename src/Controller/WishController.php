<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WichType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/wish', name: 'wish')]
#[IsGranted('ROLE_USER')]
final class WishController extends AbstractController
{

    #[Route('/list/{page}', name: '_list', requirements: ['page' => '\d+'], defaults: ['page' => 1], methods: ['GET'])]
    public function list(WishRepository $wishRepository, int $page, ParameterBagInterface $parameters): Response
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
        $wishes = $wishRepository->findWishCustom('henri', 8);
        return $this->render('wish/list-custom.html.twig', [
            'wishes' => $wishes,
            'page' => 1,
            'totalPages' => 30,
        ]);
    }

    #[Route('/detail/{id}', name: '_detailpage', requirements: ['id' => '\d+'], defaults: ['id' => 0])]
    public function detail(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);


        /*if (!$wish) {
            throw $this->createNotFoundException('Il n\'y a pas de souhait demandé');
        }*/

        return $this->render('wish/detail.html.twig', [
            'wish' => $wish,
        ]);
    }

    #[Route('/create', name: '_create')]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $wish = new Wish();
        $form = $this->createForm(WichType::class, $wish);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $em->persist($wish);
            $em->flush();
            $this->addFlash('success', 'Votre souhait a bien été enregistré');
//            dd($wish);

            return $this->redirectToRoute('wish_detailpage', ['id' => $wish->getId()]);
        }
        return $this->render('wish/edit.html.twig', [
            'wish_form' => $form,
        ]);
    }

    #[Route('/update/{id}', name: '_update', requirements: ['id' => '\d+'])]
    #[ISGranted('ROLE_ADMIN')]
    public function update(Wish $wish, Request $request, EntityManagerInterface $em): Response{

        $form = $this->createForm(WichType::class,$wish);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $em->flush();
            $this->addFlash('success','Votre souhait a bien été modifié');

            return $this->redirectToRoute('wish_detailpage', ['id' => $wish->getId()]);
        }

        return $this->render('wish/edit.html.twig', [
            'wish_form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: '_delete', requirements: ['id' => '\d+'])]
    #[ISGranted('ROLE_ADMIN')]
    public function delete(Wish $wish, EntityManagerInterface $em, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wish->getId(), $request->get('token'))) {
            $em->remove($wish);
            $em->flush();
            $this->addFlash('success','Votre souhait a bien été supprimé');
        } else {
            $this->addFlash('danger','Suppression impossible');
        }


        return $this->redirectToRoute('wish_list');
    }

}
