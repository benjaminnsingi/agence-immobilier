<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use App\Services\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private EmailVerifier $emailVerifier;
    private MessageService $messageService;

    public function __construct(EntityManagerInterface $entityManager, EmailVerifier $emailVerifier, MessageService $messageService) {

        $this->entityManager = $entityManager;
        $this->emailVerifier = $emailVerifier;
        $this->messageService = $messageService;
    }

    #[Route('/registration', name: 'registration')]
    public function register(Request $request, UserPasswordEncoderInterface $encoder, GuardAuthenticatorHandler $guardAuthenticatorHandler, LoginFormAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (!$search_email) {
                // encode the password
                $password = $encoder->encodePassword($user, $user->getPassword());

                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $this->messageService->addSuccess("Un message de confirmation vient de vous être envoyer sur votre adresse email");

                // generate a signed url and email it to the user
                $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                    (new TemplatedEmail())
                     ->from(new Address('agenceimmobilier@agence.com', 'agence immobilier'))
                     ->to($user->getEmail())
                     ->subject('Veuillez confirmer votre adresse email')
                     ->htmlTemplate('registration/confirmation_email.html.twig')
                );

                return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main'
                );

            } else {
                  $this->messageService->addError("L'email que vous avez renseigné existe dejà");
            }

        }

        return $this->render('registration/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/verify/email", name: "app_verify_email")]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('registration');
        }

        $this->messageService->addSuccess('Votre adresse email a été vérifiée.');

        return $this->redirectToRoute('account');
    }
}
