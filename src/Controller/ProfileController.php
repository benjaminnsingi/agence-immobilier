<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Services\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/profile")]
class ProfileController extends AbstractController
{
    private MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    #[Route('', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
    }

    #[Route('/edit', name: 'app_profile_edit', methods: ["GET|POST"])]
    public function edit(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('image')->getData();
            $fileName = md5(uniqid()). '.'. $uploadedFile->getExtension();
            $uploadedFile->move($this->getParameter('images_directory'), $fileName);

            $user->setImageProfile($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->messageService->addSuccess('Profile est mis à jour ');
        }

        return $this->render('profile/profile.html.twig',[
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
