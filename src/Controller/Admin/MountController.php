<?php

namespace App\Controller\Admin;

use App\Entity\Mount;
use App\Form\MountType;
use App\Repository\MountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

/**
 * @Route("/admin/mount")
 */
class MountController extends AbstractController
{
    /**
     * @Route("/", name="mount_index", methods={"GET"})
     */
    public function index(MountRepository $mountRepository): Response
    {
        return $this->render('admin/mount/index.html.twig', [
            'mounts' => $mountRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mount_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $mount = new Mount();
        $form = $this->createForm(MountType::class, $mount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            /** @var file $file */
            $file = $form['image']->getData();
            if ($file)
            {
                $fileName = $this->generateUniqueFileName() . "." . $file->guessExtension();
                try{
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e){
                }
                $mount->setImage($fileName);
            }
            $entityManager->persist($mount);
            $entityManager->flush();

            return $this->redirectToRoute('mount_index');
        }

        return $this->render('admin/mount/new.html.twig', [
            'mount' => $mount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mount_show", methods={"GET"})
     */
    public function show(Mount $mount): Response
    {
        return $this->render('admin/mount/show.html.twig', [
            'mount' => $mount,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mount_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Mount $mount): Response
    {
        $form = $this->createForm(MountType::class, $mount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var file $file */
            $file = $form['image']->getData();
            if ($file)
            {
                $fileName = $this->generateUniqueFileName() . "." . $file->guessExtension();
                try{
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e){
                }
                $mount->setImage($fileName);
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('mount_index');
        }

        return $this->render('admin/mount/edit.html.twig', [
            'mount' => $mount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mount_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Mount $mount): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mount->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mount_index');
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

}
