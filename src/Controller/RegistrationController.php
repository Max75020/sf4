<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em, MailerInterface $mail)
    {
        $registration_Form = $this->createForm(RegistrationFormType::class);
        $registration_Form->handleRequest($request);

        if ($registration_Form->isSubmitted() && $registration_Form->isValid()) {
            $user = $registration_Form->getData();
            $password = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $password);
            $user->setPassword($encoded)
                ->setIsConfirmed(false)
                ->renewToken();
            $em->persist($user);
            $em->flush();


            $email = (new mail())
                ->from('fabien@example.com')
                ->to(new Address('bourdonnne.chris@gmail.Com'))
                ->subject('Thanks for signing up!')

                // path of the Twig template to render
                ->htmlTemplate('emails/signup.html.twig')

                // pass variables (name => value) to the template
                ->context([
                    'expiration_date' => new \DateTime('+7 days'),
                    'username' => 'foo',
                ]);

            $this->addFlash('success', 'Inscription reussi.Veuillez consulter votre boite email pour confirmer votre adresse email');
        }
        return $this->render('user/registration.html.twig', [
            'registration_form' => $registration_Form->createView()
        ]);
    }

}