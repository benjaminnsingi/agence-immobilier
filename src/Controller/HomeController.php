<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Property;
use App\Form\SearchForm;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PropertyRepository $propertyRepository, Request $request): Response
    {
       $data = new SearchData();
       $data->page = $request->get('page', 1);
       $form = $this->createForm(SearchForm::class, $data);
       $form->handleRequest($request);
       [$min, $max] = $propertyRepository->findMinMax($data);
       $properties = $propertyRepository->findSearch($data);

        return $this->render('home/index.html.twig', [
            'properties' => $properties,
            'form' => $form->createView(),
            'min' => $min,
            'max' => $max
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
