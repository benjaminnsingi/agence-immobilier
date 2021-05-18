<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'properties' => $propertyRepository->findAll()
        ]);
    }

    #[Route('/real-estate/{id}', name: 'property.show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('home/show.html.twig', [
            'property' => $property,
        ]);
    }
}
