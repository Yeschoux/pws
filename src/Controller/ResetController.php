<?php

namespace App\Controller;

use App\Entity\Reset;
use App\Form\ResetType;
use App\Repository\ResetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reset")
 */
class ResetController extends AbstractController
{
    /**
     * @Route("/", name="reset_index", methods={"GET"})
     */
    public function index(ResetRepository $resetRepository): Response
    {
        return $this->render('reset/index.html.twig', [
            'resets' => $resetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reset_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reset = new Reset();
        $form = $this->createForm(ResetType::class, $reset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reset);
            $entityManager->flush();

            return $this->redirectToRoute('reset_index');
        }

        return $this->render('reset/new.html.twig', [
            'reset' => $reset,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reset_show", methods={"GET"})
     */
    public function show(Reset $reset): Response
    {
        return $this->render('reset/show.html.twig', [
            'reset' => $reset,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reset_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reset $reset): Response
    {
        $form = $this->createForm(ResetType::class, $reset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reset_index');
        }

        return $this->render('reset/edit.html.twig', [
            'reset' => $reset,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reset_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reset $reset): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reset->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reset);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reset_index');
    }
}
