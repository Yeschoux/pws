<?php

namespace App\Controller\Admin;

use App\Entity\Expansion;
use App\Form\ExpansionType;
use App\Repository\ExpansionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/expansion")
 */
class ExpansionController extends AbstractController
{
    /**
     * @Route("/", name="expansion_index", methods={"GET"})
     */
    public function index(ExpansionRepository $expansionRepository): Response
    {
        return $this->render('admin/expansion/index.html.twig', [
            'expansions' => $expansionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="expansion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $expansion = new Expansion();
        $form = $this->createForm(ExpansionType::class, $expansion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($expansion);
            $entityManager->flush();

            return $this->redirectToRoute('expansion_index');
        }

        return $this->render('admin/expansion/new.html.twig', [
            'expansion' => $expansion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="expansion_show", methods={"GET"})
     */
    public function show(Expansion $expansion): Response
    {
        return $this->render('admin/expansion/show.html.twig', [
            'expansion' => $expansion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="expansion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Expansion $expansion): Response
    {
        $form = $this->createForm(ExpansionType::class, $expansion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('expansion_index');
        }

        return $this->render('admin/expansion/edit.html.twig', [
            'expansion' => $expansion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="expansion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Expansion $expansion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$expansion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($expansion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('expansion_index');
    }
}
