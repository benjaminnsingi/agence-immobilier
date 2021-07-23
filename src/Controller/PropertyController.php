<?php


namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use App\Repository\PropertyRepository;
use App\Services\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private PropertyRepository $repository;

    private MessageService $messageService;

    public function __construct(EntityManagerInterface $entityManager, PropertyRepository $repository, MessageService $service)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->messageService = $service;
    }

    #[Route("/biens", name: "property.index", methods: ['GET'])]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        return $this->render('pages/property.html.twig', [
            'current_menu' => 'properties',
            'properties'   => $this->repository->paginateAllVisible($search, $request->query->getInt('page', 1)),
            'form'         => $form->createView()
        ]);
    }

    ##[Route("/biens/{slug}-{id}", name: "property.show", requirements: ["slug: [a-z0-9\-]*"])]##
    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug, Request $request, ContactNotification $notification): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id'   => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        $contact = new Contact();
        $contact->setProperty((string)$property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact);
            $this->messageService->addSuccess('Votre email a bien été envoyé');
            return $this->redirectToRoute('property.show', [
                'id'   => $property->getId(),
                'slug' => $property->getSlug()
            ]);
        }

        return $this->render('pages/show.html.twig', [
            'property'     => $property,
            'current_menu' => 'properties',
            'form' => $form->createView()
        ]);
    }
}
