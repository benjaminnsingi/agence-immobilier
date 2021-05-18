<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Property;
use App\Entity\User;
use App\Form\PropertyType;
use App\Services\ManagePicturesService;
use App\Services\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/users')]
class PropertyController extends AbstractController
{
    private MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    #[Route('/', name: 'property_index', methods: ['GET'])]
    public function index(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager,PaginatorInterface $paginator, Request $request): Response
    {
        $token = $tokenStorage->getToken();
        $currentUser = null !== $token ? $token->getUser() : null;

        if (null === $currentUser) {
            throw new UnauthorizedHttpException('Non autorisé');
        }

        $qb = $entityManager->createQueryBuilder()
             ->select('p')
             ->from(Property::class, 'p');

        $currentRoles = $currentUser->getRoles();

        if (!in_array('ROLE_ADMIN', $currentRoles))
        {
            $qb
                ->where('p.user = :user')
                ->setParameter('user', $currentUser)
            ;
        }

        $properties = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('property/index.html.twig', [
            'properties' => $properties,
        ]);
    }

    #[Route('/users/create', name: 'property_new', methods: ['GET', 'POST'])]
    public function create(Request $request, ManagePicturesService $managePicturesService): Response
    {
        $property = new Property();
        /** @var User $user */
        $user = $this->getUser();
        $property->setUser($user);
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We recover the transmitted images
            $pictures = $form->get('images')->getData();

            // We add the images
            $managePicturesService->add($pictures, $property);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($property);
            $entityManager->flush();
            $this->messageService->addSuccess('Bien crée avec succès');

            return $this->redirectToRoute('property_index');
        }

        return $this->render('property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'property_show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }

    #[Route('/{id}/edit', name: 'property_edit', methods: ['GET', 'POST'])]
    public function update(Request $request, Property $property, ManagePicturesService $managePicturesService): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // We recover the transmitted images
            $pictures = $form->get('images')->getData();

            // We add the images
            $managePicturesService->add($pictures, $property);

            $this->getDoctrine()->getManager()->flush();

            $this->messageService->addSuccess('Bien modifié avec succès');
            return $this->redirectToRoute('property_index');
        }

        return $this->render('property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'property_delete', methods: ['POST'])]
    public function delete(Request $request, Property $property): Response
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($property);
            $entityManager->flush();
            $this->messageService->addSuccess('Bien supprimé avec succès');
        }

        return $this->redirectToRoute('property_index');
    }

    #[Route('/delete/picture/{id}', name: 'property_delete_image', methods: ['DELETE'])]
    public function deleteImage(Picture $picture, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // We check if the token is valid
        if ($this->isCsrfTokenValid('delete'.$picture->getId(), $data['_token'])) {
            // Delete the entry from the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($picture);
            $entityManager->flush();

            // We respond in json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
