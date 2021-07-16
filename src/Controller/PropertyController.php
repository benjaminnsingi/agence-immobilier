<?php


namespace App\Controller;


use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
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

    public function __construct(EntityManagerInterface $entityManager, PropertyRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
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
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id'   => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('pages/show.html.twig', [
            'property'     => $property,
            'current_menu' => 'properties',
        ]);
    }
}
