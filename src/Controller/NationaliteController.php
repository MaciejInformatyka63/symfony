<?php

namespace App\Controller;

use App\Entity\Nationalite;
use App\Form\NationaliteType;
use App\Repository\NationaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/nationalite')]
class NationaliteController extends AbstractController
{
    #[Route('/', name: 'app_nationalite_index', methods: ['GET'])]
    public function index(NationaliteRepository $nationaliteRepository): Response
    {
        return $this->render('nationalite/index.html.twig', [
            'nationalites' => $nationaliteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_nationalite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NationaliteRepository $nationaliteRepository): Response
    {
        $nationalite = new Nationalite();
        $form = $this->createForm(NationaliteType::class, $nationalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nationaliteRepository->save($nationalite, true);

            return $this->redirectToRoute('app_nationalite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nationalite/new.html.twig', [
            'nationalite' => $nationalite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nationalite_show', methods: ['GET'])]
    public function show(Nationalite $nationalite): Response
    {
        return $this->render('nationalite/show.html.twig', [
            'nationalite' => $nationalite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nationalite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Nationalite $nationalite, NationaliteRepository $nationaliteRepository): Response
    {
        $form = $this->createForm(NationaliteType::class, $nationalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nationaliteRepository->save($nationalite, true);

            return $this->redirectToRoute('app_nationalite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nationalite/edit.html.twig', [
            'nationalite' => $nationalite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nationalite_delete', methods: ['POST'])]
    public function delete(Request $request, Nationalite $nationalite, NationaliteRepository $nationaliteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nationalite->getId(), $request->request->get('_token'))) {
            $nationaliteRepository->remove($nationalite, true);
        }

        return $this->redirectToRoute('app_nationalite_index', [], Response::HTTP_SEE_OTHER);
    }
}
