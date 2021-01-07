<?php

namespace App\Controller\Admin;

use App\Entity\CurrencyType;
use App\Form\CurrencyTypeType;
use App\Repository\CurrencyTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/currency_type")
 */
class CurrencyTypeController extends AbstractController
{
    /**
     * @Route("/", name="currency_type_index", methods={"GET"})
     */
    public function index(CurrencyTypeRepository $currencyTypeRepository): Response
    {
        return $this->render('admin/currency_type/index.html.twig', [
            'currency_types' => $currencyTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="currency_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $currencyType = new CurrencyType();
        $form = $this->createForm(CurrencyTypeType::class, $currencyType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currencyType);
            $entityManager->flush();

            return $this->redirectToRoute('currency_type_index');
        }

        return $this->render('admin/currency_type/new.html.twig', [
            'currency_type' => $currencyType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="currency_type_show", methods={"GET"})
     */
    public function show(CurrencyType $currencyType): Response
    {
        return $this->render('admin/currency_type/show.html.twig', [
            'currency_type' => $currencyType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="currency_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CurrencyType $currencyType): Response
    {
        $form = $this->createForm(CurrencyTypeType::class, $currencyType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('currency_type_index');
        }

        return $this->render('admin/currency_type/edit.html.twig', [
            'currency_type' => $currencyType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="currency_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CurrencyType $currencyType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$currencyType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($currencyType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('currency_type_index');
    }
}
