<?php

namespace App\Controller;

use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private PropertyRepository $repository;

    public function __construct(EntityManagerInterface $entityManager, PropertyRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    #[Route('/', name: 'home')]
    public function index(PropertyRepository $propertyRepository, Request $request): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        $properties = $propertyRepository->findLatest();
        return $this->render('pages/home.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'form'       => $form->createView()
        ]);
    }
}
