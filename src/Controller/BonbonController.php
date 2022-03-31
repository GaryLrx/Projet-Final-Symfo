<?php

namespace App\Controller;

use App\Entity\Bonbon;
use App\Form\BonbonType;
use App\Repository\BonbonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bonbon')]
class BonbonController extends AbstractController
{
    #[Route('/', name: 'app_bonbon_index', methods: ['GET'])]
    public function index(BonbonRepository $bonbonRepository): Response
    {
        return $this->render('bonbon/index.html.twig', [
            'bonbons' => $bonbonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bonbon_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BonbonRepository $bonbonRepository): Response
    {
        $bonbon = new Bonbon();
        $form = $this->createForm(BonbonType::class, $bonbon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bonbonRepository->add($bonbon);
            return $this->redirectToRoute('app_bonbon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bonbon/new.html.twig', [
            'bonbon' => $bonbon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bonbon_show', methods: ['GET'])]
    public function show(Bonbon $bonbon): Response
    {
        return $this->render('bonbon/show.html.twig', [
            'bonbon' => $bonbon,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bonbon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bonbon $bonbon, BonbonRepository $bonbonRepository): Response
    {
        $form = $this->createForm(BonbonType::class, $bonbon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bonbonRepository->add($bonbon);
            return $this->redirectToRoute('app_bonbon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bonbon/edit.html.twig', [
            'bonbon' => $bonbon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bonbon_delete', methods: ['POST'])]
    public function delete(Request $request, Bonbon $bonbon, BonbonRepository $bonbonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bonbon->getId(), $request->request->get('_token'))) {
            $bonbonRepository->remove($bonbon);
        }

        return $this->redirectToRoute('app_bonbon_index', [], Response::HTTP_SEE_OTHER);
    }
}
