<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\User;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use App\Services\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

#[Route('/property')]
class PropertyController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private MessageService $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    #[Route('/', name: 'property_index', methods: ['GET'])]
    public function index(TokenStorageInterface $tokenStorage, Paginator $paginator, Request $request): Response
    {
        $token = $tokenStorage->getToken();
        $currentUser = null !== $token ? $token->getUser() : null;

        if (null === $currentUser) {
            throw new UnauthorizedHttpException('Non autorisé');
        }

        $qb = $this->entityManager->createQueryBuilder()
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

    #[Route('/new', name: 'property_new', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $property = new Property();
        /** @var User $user */
        $user = $this->getUser();
        $property->setUser($user);
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function update(Request $request, Property $property): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
}
