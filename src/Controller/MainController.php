<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\CurrencyTypeType;
use App\Form\ExpansionType;
use App\Form\User1Type;
use App\Repository\CommentRepository;
use App\Repository\CurrencyTypeRepository;
use App\Repository\ExpansionRepository;
use App\Repository\MountRepository;
use App\Repository\SourceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\File;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(MountRepository $mountRepository): Response
    {
        $latest_mounts = $mountRepository->findBy([],['id'=>'DESC'],4);
        return $this->render('home/index.html.twig', [
            'page' => 'home',
            'latest_mounts' => $latest_mounts,
        ]);
    }


    /**
     * @Route("/mount/{id}", name="mount")
     */
    public function mount($id, MountRepository $mountRepository, CommentRepository $commentRepository, Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setMountid($id);
            $comment->setUserid($user->getId());
            $comment->setUname($user->getUname());
            $comment->setCreatedAt(new \DateTime('now'));
            $comment->setStatus('new');
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('mount', ['id' => $id]);
        }
        $comment = $commentRepository->findBy(['mountid' => $id]);
        $mount = $mountRepository->findOneBy(['id' => $id]);
        return $this->render('home/monture_profile.html.twig', [
            'comments' => $comment,
            'form' => $form->createView(),
            'page' => 'research',
            'mount' => $mount,
        ]);
    }

    /**
     * @Route("/comment/{id}", name="new_comment")
     */
    public function comment($id, MountRepository $mountRepository): Response
    {


        $mount = $mountRepository->findOneBy(['id' => $id]);
        return $this->render('home/monture_profile.html.twig', [
            'page' => 'research',
            'mount' => $mount,
        ]);
    }


    /**
     * @Route("/profile", name="profile")
     */
    public function profile(): Response
    {
        return $this->render('home/profile.html.twig', [
            'page' => 'profile',
            'controller_name' => 'MainController',
        ]);
    }
    /**
     * @Route("/profile/edit", name="edit_profile")
     */
    public function edit_profile(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(User1Type::class, $user);
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
                $user->setImage($fileName);
            }

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('profile');
        }

        return $this->render('home/edit_profile.html.twig', [
            'form' => $form->createView(),
            'page' => 'profile',
            'controller_name' => 'MainController',
        ]);
    }


    /**
     * @Route("/profile/change_password", name="change_password")
     */
    public function change_password(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();

        if($request->getMethod() == 'POST')
        {
            $old_password = $request->request->get('old_password');
            $checkPass = $passwordEncoder->isPasswordValid($user, $old_password);
            if ($checkPass === true)
            {
                $new_password = $request->request->get('new_password');
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $new_password
                    )
                );
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('login');
            }

        }
        return $this->render('home/change_password.html.twig', [
            'page' => 'profile',
        ]);
    }


    /**
     * @Route("/research", name="research")
     */
    public function research(Request $request, ExpansionRepository $expansionRepository, SourceRepository $sourceRepository, CurrencyTypeRepository $currencyTypeRepository, PaginatorInterface $paginator, MountRepository $mountRepository): Response
    {
        $expansions = $expansionRepository->findAll();
        $sources = $sourceRepository->findAll();
        $currencies = $currencyTypeRepository->findAll();

        if($request->getMethod()== 'POST')
        {
            $name = $request->request->get('name');
            $faction = $request->request->get('faction');
            $exp = $request->request->get('expansion_form');
            $type = $request->request->get('type');
            $source = $request->request->get('source');
            $currency = $request->request->get('currency');


            $filtered_mounts = $mountRepository->findAllQueryBuilder($name, $faction, $type, $exp, $source, $currency)->getQuery();

            $mounts = $paginator->paginate(
                $filtered_mounts,
                $request->query->getInt('page', 1),
                10
            );

            return $this->render('home/research.html.twig', [
                'expansions' => $expansions,
                'sources' => $sources,
                'currency' => $currencies,
                'page' => 'research',
                'mounts' => $mounts,
            ]);

        }


        $mount_query = $mountRepository->createQueryBuilder('m')->getQuery();
        // Paginate the results of the query
        $mounts = $paginator->paginate(
            $mount_query,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('home/research.html.twig', [
            'expansions' => $expansions,
            'sources' => $sources,
            'currency' => $currencies,
            'page' => 'research',
            'mounts' => $mounts,
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
