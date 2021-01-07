<?php

namespace App\Controller;

use App\Entity\Reset;
use App\Form\ResetType;
use App\Repository\ResetRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $user = $this->getUser();
            if ($user->getRoles()[0] == 'ROLE_ADMIN' or $user->getRoles()[0] == 'ROLE_MOD')
                return $this->redirectToRoute('admin');
            else
                return $this->redirectToRoute('main');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('home/identification.html.twig', [
            'page' => 'reg',
            'last_username' => $lastUsername,
            'error' => $error]);
    }




    /**
     * @Route("/enter_code/{email}", name="forgot_pwd_code")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function enter_code($email, Request $request,UserRepository $userRepository, ResetRepository $resetRepository, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $check = $resetRepository->findOneBy(['email' => $email]);
        if($check)
        {
            if($request->getMethod() == 'POST')
            {
                $code = $request->request->get('code');
                if($check->getCode() == $code)
                {
                    $user = $userRepository->findOneBy(['email'=> $email]);
                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $code
                        )
                    );
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();


                    $entityManager->remove($check);
                    $entityManager->flush();
                    return $this->redirectToRoute('login');
                }
            }




            return $this->render('home/forgot_password_code.html.twig', [
                'page' => 'reg',]);
        }


    }



    /**
     * @Route("/forgot_password", name="forgot_pwd", methods={"GET","POST"})
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function forgot_pwd(Request $request, MailerInterface $mailer): Response
    {
        $reset = new Reset();
        $form = $this->createForm(ResetType::class, $reset);
        $form->handleRequest($request);
        $submittedToken = $request->request->get('_token');



        if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();
                $email_addr = $form['email']->getData();
                $code = $this->generateUniquePassword();
                $reset->setEmail($email_addr);
                $reset->setCode($code);
                $entityManager->persist($reset);
                $entityManager->flush();

                //********** SEND EMAIL ***********************>>>>>>>>>>>>>>>
                $email = (new Email())
                    ->from('futiseven@gmail.com')
                    ->to($email_addr)
                    ->subject('Password Reset')
                    ->text('Your code is:'.$code);

                $mailer->send($email);

                return $this->redirectToRoute('forgot_pwd_code', ['email' => $email_addr]);

        }

        return $this->render('home/forgot_password_email.html.twig', [
            'form' => $form->createView(),
            'page' => 'reg',]);
    }



    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @return string
     */
    private function generateUniquePassword()
    {
        return substr(md5(uniqid()), 0, 5);
    }
}
